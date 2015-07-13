<?php

namespace BankClient\Domain\Service;

use BankClient\Domain\Contract\HttpBankClientInterface;
use BankClient\Domain\Repository\TransactionRepositoryInterface;
use BankClient\Domain\Entity\Transaction;

class BillingService
{
	protected $httpClient;
	protected $transaction;
	protected $transactionRepository;

	public function __construct(
		HttpBankClientInterface $httpClient,
		Transaction $transaction,
		TransactionRepositoryInterface $transactionRepository
	) {
		$this->httpClient = $httpClient;
		$this->transaction = $transaction;
		$this->transactionRepository = $transactionRepository;
	}

	public function conductTransaction($amount)
	{
		$this->setTransactionStatus(Transaction::STATUS_NEW);

		if ($this->httpClient->authenticate()) {
			$this->setTransactionStatus(Transaction::STATUS_PENDING);

			if ($this->httpClient->bill($amount)) {
				$this->setTransactionStatus(Transaction::STATUS_COMPLETED);

				return;
			}
		}

		$this->setTransactionStatus(Transaction::STATUS_FAILED);
	}

	protected function recordTransaction()
	{
		$this->transactionRepository
			->persist($this->transaction);

		return $this;
	}

	protected function setTransactionStatus($status)
	{
		$this->transaction->setStatus($status);
		$this->recordTransaction();
	}
}
