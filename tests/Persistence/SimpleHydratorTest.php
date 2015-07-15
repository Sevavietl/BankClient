<?php

use BankClient\Domain\Service\BillingService;

use Prophecy\Prophet;

use BankClient\Domain\Entity\Transaction;

use BankClient\Persistence\Laravel\Hydrator\SimpleHydrator;

class SimpleHydratorTest extends PHPUnit_Framework_TestCase
{
	private $prophet;

	protected $entity;
	protected $hydrator;

	public function setUp()
    {
		$this->prophet = new Prophet;

		$this->entity = $this->prophet
			->prophesize('BankClient\Domain\Entity\Transaction');

		$this->hydrator = new SimpleHydrator;
    }

	public function tearDown()
    {
		$this->prophet->checkPredictions();
    }

	/**
	 * Test extraction
	 */
	public function testExtract()
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

	// /**
	//  * Transaction authenticated but not billed
	//  */
	// public function testConductTransactionAuthenticatedNotBilled()
	// {
	// 	$this->transaction->setStatus(Transaction::STATUS_NEW)->shouldBeCalled();
	// 	$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
	// 	$this->httpClient->authenticate()->willReturn(true);
	// 	$this->transaction->setStatus(Transaction::STATUS_PENDING)->shouldBeCalled();
	// 	$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
	// 	$this->transaction->getAmount()->willReturn(5);
	// 	$this->httpClient->bill(5)->willReturn(false);
	// 	$this->transaction->setStatus(Transaction::STATUS_FAILED)->shouldBeCalled();
	// 	$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
	//
	// 	$billingService = new BillingService(
	// 		$this->httpClient->reveal(),
	// 		$this->transaction->reveal(),
	// 		$this->transactionRepository->reveal()
	// 	);
	//
	// 	$this->assertFalse($billingService->conductTransaction());
	// }
	//
	// /**
	//  * Transaction authenticated an billed
	//  */
	// public function testConductTransactionAuthenticatedBilled()
	// {
	// 	$this->transaction->setStatus(Transaction::STATUS_NEW)->shouldBeCalled();
	// 	$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
	// 	$this->httpClient->authenticate()->willReturn(true);
	// 	$this->transaction->setStatus(Transaction::STATUS_PENDING)->shouldBeCalled();
	// 	$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
	// 	$this->transaction->getAmount()->willReturn(5);
	// 	$this->httpClient->bill(5)->willReturn(true);
	// 	$this->transaction->setStatus(Transaction::STATUS_COMPLETED)->shouldBeCalled();
	// 	$this->transactionRepository->persist($this->transaction)->shouldBeCalled();
	//
	// 	$billingService = new BillingService(
	// 		$this->httpClient->reveal(),
	// 		$this->transaction->reveal(),
	// 		$this->transactionRepository->reveal()
	// 	);
	//
	// 	$this->assertTrue($billingService->conductTransaction());
	// }
}
