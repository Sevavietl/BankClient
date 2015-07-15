<?php

namespace BankClient\Domain\Service;

use BankClient\Domain\Contract\HttpBankClientInterface;
use BankClient\Domain\Repository\TransactionRepositoryInterface;
use BankClient\Domain\Entity\Transaction;

class BillingService
{
	/**
	 * Client to communicate with Bank Server
	 * @var BankClient\Domain\Contract\HttpBankClientInterface
	 */
	protected $httpClient;
	/**
	 * [$transaction description]
	 * @var BankClient\Domain\Entity\Transaction
	 */
	protected $transaction;
	/**
	 * [$transactionRepository description]
	 * @var BankClient\Domain\Repository\TransactionRepositoryInterface
	 */
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

	/**
	 * Conduct transaction
	 * @return boolean
	 */
	public function conductTransaction()
	{
		// Initialize transaction
		$this->setTransactionStatus(Transaction::STATUS_NEW);

		// Authenticate
		if ($this->httpClient->authenticate()) {
			$this->setTransactionStatus(Transaction::STATUS_PENDING);

			// Withdraw money
			if ($this->httpClient->bill($this->transaction->getAmount())) {
				$this->setTransactionStatus(Transaction::STATUS_COMPLETED);

				return true;
			}
		}

		$this->setTransactionStatus(Transaction::STATUS_FAILED);
		return false;
	}

	/**
	 * Record transaction using repository
	 * @return BankClient\Domain\Service\BillingService
	 */
	protected function recordTransaction()
	{
		$this->transactionRepository
			->persist($this->transaction);

		return $this;
	}

	/**
	 * Set status for transaction
	 * @param string $status
	 */
	protected function setTransactionStatus($status)
	{
		$this->transaction->setStatus($status);
		$this->recordTransaction();
	}

	/**
	 * Get the last error from httpClient
	 * @return string
	 */
	public function getLastError()
	{
		return $this->httpClient->getLastError();
	}
}
