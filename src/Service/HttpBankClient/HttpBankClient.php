<?php

namespace BankClient\Service\HttpBankClient;

use BankClient\Domain\Contract\HttpBankClientInterface;
use BankClient\Domain\Entity\User;
use BankClient\Domain\Entity\Card;

use GuzzleHttp\Client;

class HttpBankClient implements HttpBankClientInterface
{
	protected $user;
	protected $card;
	protected $client;
	protected $token;
	protected $lastError;
	protected $baseUri = '';

	// uris
	protected $autheticateUri = 'authenticate';
	protected $billUri = 'bill';

	public function __construct()
	{
		$this->client = new Client([
			'base_uri' => $this->baseUri,
		]);
	}

	public function setUser(User $user)
	{
		$this->user = $user;

		return $this;
	}

	public function setCard(Card $card)
	{
		$this->card = $card;

		return $this;
	}

	public function authenticate()
	{
		return true;

		$response = $this->client->post(
			$this->authenticateUri,
			[
				'user' => $this->user,
				'card' => $this->card,
			]
		);

		if ($response->getStatusCode() === 200) {
			return true;
		}


		return false;
	}

	public function bill($amount)
	{
		return true;
		$response = $this->client->get($this->billUri);

		if ($response->getStatusCode() === 200) {
			return true;
		}


		return false;
	}
}
