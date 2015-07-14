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
	protected $baseUri = 'http://localhost:8001/transaction/';

	// uris
	protected $authenticateUri = 'authenticate';
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
		$response = $this->client->post(
			$this->authenticateUri,
			[
				'form_params' => [
					'first_name' => $this->user->getFirstName(),
	       			'last_name' => $this->user->getLastName(),
	       			'card_number' => $this->card->getCardNumber(),
	       			'card_expiration' => $this->card->getCardExpiration(),
				]
			]
		);

		$result = json_decode((string) $response->getBody());

		dd($result);

		if ($result->authenticated) {
			$this->token = $result->token;
			return true;
		}

		$this->lastError = $result->error;
		return false;
	}

	public function bill($amount)
	{
		$response = $this->client->post(
			$this->billUri,
			[
				'token' => $this->token,
				'amount' => $amount,
			]
		);

		$result = json_decode((string) $response->getBody());

		if ($result->billed) {
			return true;
		}
		
		$this->lastError = $result->error;
		return false;
	}
}
