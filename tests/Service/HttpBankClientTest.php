<?php

use BankClient\Service\HttpBankClient\HttpBankClient;

use Prophecy\Prophet;

class HttpBankClientTest extends PHPUnit_Framework_TestCase
{
	private $prophet;

	protected $client;
	protected $response;

	protected $user;
	protected $card;

	public function setUp()
    {
		$this->prophet = new Prophet;

		$this->client = $this->prophet
			->prophesize('GuzzleHttp\ClientInterface');
		$this->response = $this->prophet
			->prophesize('GuzzleHttp\Psr7\Response');

		$this->user = $this->prophet
			->prophesize('BankClient\Domain\Entity\User');

		$this->card = $this->prophet
			->prophesize('BankClient\Domain\Entity\Card');

		$this->user->getFirstName()->willReturn('John');
		$this->user->getLastName()->willReturn('Dow');
		$this->card->getCardNumber()->willReturn('1234 1234 1234 1234');
		$this->card->getCardExpiration()->willReturn('07/16');
    }

	public function tearDown()
    {
		$this->prophet->checkPredictions();
    }

	/**
	 * Transaction not authenticated
	 */
	public function testNotAuthenticated()
	{
		$error = 'Card Verification Error';

		$this->response
			->getBody()
			->willReturn(json_encode([
				'authenticated' => false,
				'error' => $error,
			]));

		$this->client->post(
			'authenticate',
			[
				'form_params' => [
					'first_name' => 'John',
	       			'last_name' => 'Dow',
	       			'card_number' => '1234 1234 1234 1234',
	       			'card_expiration' => '07/16',
				]
			]
		)->willReturn($this->response->reveal());

		$httpBankClient = new HttpBankClient($this->client->reveal());
		$httpBankClient->setUser($this->user->reveal());
		$httpBankClient->setCard($this->card->reveal());

		$this->assertFalse($httpBankClient->authenticate());
		$this->assertEquals($httpBankClient->getLastError(), $error);
	}

	/**
	 * Transaction not authenticated
	 */
	public function testAuthenticated()
	{
		$token = 'foobar';

		$this->response
			->getBody()
			->willReturn(json_encode([
				'authenticated' => true,
				'token' => $token,
			]));

		$this->client->post(
			'authenticate',
			[
				'form_params' => [
					'first_name' => 'John',
	       			'last_name' => 'Dow',
	       			'card_number' => '1234 1234 1234 1234',
	       			'card_expiration' => '07/16',
				]
			]
		)->willReturn($this->response->reveal());

		$httpBankClient = new HttpBankClient($this->client->reveal());
		$httpBankClient->setUser($this->user->reveal());
		$httpBankClient->setCard($this->card->reveal());

		$this->assertTrue($httpBankClient->authenticate());
		$this->assertEquals($httpBankClient->getToken(), $token);
	}

	/**
	 * Transaction not billed
	 */
	public function testNotBilled()
	{
		$token = 'foobar';
		$amount = 5;
		$error = 'Not Enough Money';

		$this->response
			->getBody()
			->willReturn(json_encode([
				'billed' => false,
				'error' => $error,
			]));

		$this->client->post(
			'bill',
			[
				'form_params' => [
					'token' => $token,
					'amount' => $amount,
				]
			]
		)->willReturn($this->response->reveal());

		$httpBankClient = new HttpBankClient($this->client->reveal());
		$httpBankClient->setToken($token);

		$this->assertFalse($httpBankClient->bill($amount));
		$this->assertEquals($httpBankClient->getLastError(), $error);
	}

	/**
	 * Transaction not billed
	 */
	public function testBilled()
	{
		$token = 'foobar';
		$amount = 5;

		$this->response
			->getBody()
			->willReturn(json_encode([
				'billed' => true,
			]));

		$this->client->post(
			'bill',
			[
				'form_params' => [
					'token' => $token,
					'amount' => $amount,
				]
			]
		)->willReturn($this->response->reveal());

		$httpBankClient = new HttpBankClient($this->client->reveal());
		$httpBankClient->setToken($token);

		$this->assertTrue($httpBankClient->bill($amount));
	}
}
