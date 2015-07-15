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

	public function conductTransaction()
	{
		$this->setTransactionStatus(Transaction::STATUS_NEW);

		if ($this->httpClient->authenticate()) {
			$this->setTransactionStatus(Transaction::STATUS_PENDING);

			if ($this->httpClient->bill($this->transaction->getAmount())) {
				$this->setTransactionStatus(Transaction::STATUS_COMPLETED);

				return true;
			}
		}

		$this->setTransactionStatus(Transaction::STATUS_FAILED);
		return false;
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

	public function getLastError()
	{
		return $this->httpClient->getLastError();
	}
}
