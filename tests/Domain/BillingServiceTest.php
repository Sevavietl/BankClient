<?php

use BankClient\Domain\Service\BillingService;

use Prophecy\Prophet;

use BankClient\Domain\Entity\Transaction;

class BillingServiceTest extends PHPUnit_Framework_TestCase
{
	private $prophet;

	protected $httpClient;
	protected $transaction;
	protected $transactionRepository;

	public function setUp()
    {
		$this->prophet = new Prophet;

		$this->httpClient = $this->prophet
			->prophesize('BankClient\Service\HttpBankClient\HttpBankClient')
			->willImplement('BankClient\Domain\Contract\HttpBankClientInterface');
		$this->transaction = $this->prophet
			->prophesize('BankClient\Domain\Entity\Transaction');
		$this->transactionRepository = $this->prophet
			->prophesize('BankClient\Persistence\Laravel\Repository\TransactionRepository')
			->willImplement('BankClient\Domain\Repository\TransactionRepositoryInterface');
    }

	public function tearDown()
    {
		$this->prophet->checkPredictions();
    }

	/**
	 * Transaction not authenticated
	 */
	public function testConductTransactionNotAuthenticated()
	{
		$this->transaction->setStatus(Transaction::STATUS_NEW)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
		$this->httpClient->authenticate()->willReturn(false);
		$this->transaction->setStatus(Transaction::STATUS_FAILED)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();

		$billingService = new BillingService(
			$this->httpClient->reveal(),
			$this->transaction->reveal(),
			$this->transactionRepository->reveal()
		);

		$this->assertFalse($billingService->conductTransaction());
	}

	/**
	 * Transaction authenticated but not billed
	 */
	public function testConductTransactionAuthenticatedNotBilled()
	{
		$this->transaction->setStatus(Transaction::STATUS_NEW)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
		$this->httpClient->authenticate()->willReturn(true);
		$this->transaction->setStatus(Transaction::STATUS_PENDING)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
		$this->transaction->getAmount()->willReturn(5);
		$this->httpClient->bill(5)->willReturn(false);
		$this->transaction->setStatus(Transaction::STATUS_FAILED)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();

		$billingService = new BillingService(
			$this->httpClient->reveal(),
			$this->transaction->reveal(),
			$this->transactionRepository->reveal()
		);

		$this->assertFalse($billingService->conductTransaction());
	}

	/**
	 * Transaction authenticated an billed
	 */
	public function testConductTransactionAuthenticatedBilled()
	{
		$this->transaction->setStatus(Transaction::STATUS_NEW)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
		$this->httpClient->authenticate()->willReturn(true);
		$this->transaction->setStatus(Transaction::STATUS_PENDING)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
		$this->transaction->getAmount()->willReturn(5);
		$this->httpClient->bill(5)->willReturn(true);
		$this->transaction->setStatus(Transaction::STATUS_COMPLETED)->shouldBeCalled();
		$this->transactionRepository->persist($this->transaction)->shouldBeCalled();

		$billingService = new BillingService(
			$this->httpClient->reveal(),
			$this->transaction->reveal(),
			$this->transactionRepository->reveal()
		);

		$this->assertTrue($billingService->conductTransaction());
	}
}
