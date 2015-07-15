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
		$this->entity->getId()->willReturn(null);
		$this->entity->getFirstName()->willReturn('John');
		$this->entity->getLastName()->willReturn('Dow');
		$this->entity->getCardNumber()->willReturn('1234 1234 1234 1234');
		$this->entity->getCardExpiration()->willReturn('07/16');
		$this->entity->getAmount()->willReturn(5);
		$this->entity->getStatus()->willReturn('new');
		$this->entity->getCreatedAt()->willReturn('2015-07-14 14:58:22');
		$this->entity->getUpdatedAt()->willReturn('2015-07-14 14:58:22');

		$this->assertEquals(
			$this->hydrator->extract($this->entity->reveal()),
			[
				'first_name' => 'John',
				'last_name' => 'Dow',
				'card_number' => '1234 1234 1234 1234',
				'card_expiration' => '07/16',
				'amount' => 5,
				'status' => 'new',
				'created_at' => '2015-07-14 14:58:22',
				'updated_at' => '2015-07-14 14:58:22',
			]
		);
	}

	/**
	 * Test insert
	 */
	public function testInsert()
	{
		$transaction = new Transaction;

		$entity = $this->hydrator->insert(
			$transaction,
			[
				'first_name' => 'John',
				'last_name' => 'Dow',
				'card_number' => '1234 1234 1234 1234',
				'card_expiration' => '07/16',
				'amount' => 5,
				'status' => 'new',
				'created_at' => '2015-07-14 14:58:22',
				'updated_at' => '2015-07-14 14:58:22',
			]
		);

		$this->assertEquals($entity->getId(), null);
		$this->assertEquals($entity->getFirstName(), 'John');
		$this->assertEquals($entity->getLastName(), 'Dow');
		$this->assertEquals($entity->getCardNumber(), '1234 1234 1234 1234');
		$this->assertEquals($entity->getCardExpiration(), '07/16');
		$this->assertEquals($entity->getAmount(), 5);
		$this->assertEquals($entity->getStatus(), 'new');
		$this->assertEquals($entity->getCreatedAt(), '2015-07-14 14:58:22');
		$this->assertEquals($entity->getUpdatedAt(), '2015-07-14 14:58:22');
	}

	/**
	* Test hydrate
	*/
	public function testHydrate()
	{
		$transaction = new Transaction;
		$request = $this->prophet->prophesize('Illuminate\Http\Request');
		$request->get('first_name')->willReturn('John');
		$request->get('last_name')->willReturn('Dow');
		$request->get('card_number')->willReturn('1234 1234 1234 1234');
		$request->get('card_expiration')->willReturn('07/16');
		$request->get('amount')->willReturn(5);
		$request->get('status')->willReturn(null);
		$request->get('created_at')->willReturn(null);
		$request->get('updated_at')->willReturn(null);

		$entity = $this->hydrator->hydrate($transaction, $request->reveal());

		$this->assertEquals($entity->getId(), null);
		$this->assertEquals($entity->getFirstName(), 'John');
		$this->assertEquals($entity->getLastName(), 'Dow');
		$this->assertEquals($entity->getCardNumber(), '1234 1234 1234 1234');
		$this->assertEquals($entity->getCardExpiration(), '07/16');
		$this->assertEquals($entity->getAmount(), 5);
		$this->assertEquals($entity->getStatus(), null);
		$this->assertEquals($entity->getCreatedAt(), null);
		$this->assertEquals($entity->getUpdatedAt(), null);

	}
}
