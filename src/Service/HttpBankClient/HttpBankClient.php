<?php

namespace BankClient\Service\HttpBankClient;

use BankClient\Domain\Contract\HttpBankClientInterface;
use BankClient\Domain\Entity\User;
use BankClient\Domain\Entity\Card;

use GuzzleHttp\ClientInterface;

class HttpBankClient implements HttpBankClientInterface
{
	protected $user;
	protected $card;
	protected $client;
	protected $token;
	protected $lastError;

	// uris
	protected $authenticateUri = 'authenticate';
	protected $billUri = 'bill';

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * [setUser description]
	 * @param BankClient\Domain\Entity\User $user [description]
	 */
	public function setUser(User $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * [setCard description]
	 * @param BankClient\Domain\Entity\Card $card [description]
	 */
	public function setCard(Card $card)
	{
		$this->card = $card;

		return $this;
	}

	/**
	 * Send authentication request
	 * @return boolean [description]
	 */
	public function authenticate()
	{
		try {
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
		} catch (\Exception $e) {
			$this->lastError = 'Could not establish connection with Bank Server';
			return false;
		}

		$result = json_decode((string) $response->getBody());

		// If authentication succeded we should recieve token
		// that will be used for billing
		if ($result->authenticated) {
			$this->token = $result->token;
			return true;
		}

		$this->lastError = $result->error;
		return false;
	}

	/**
	 * Send billing request
	 * @param  integer $amount
	 * @return boolean
	 */
	public function bill($amount)
	{
		try {
			$response = $this->client->post(
				$this->billUri,
				[
					'form_params' => [
						'token' => $this->token,
						'amount' => $amount,
					]
				]
			);
		} catch (\Exception $e) {
			$this->lastError = 'Could not establish connection with Bank Server';
			return false;
		}

		$result = json_decode((string) $response->getBody());

		if ($result->billed) {
			return true;
		}

		$this->lastError = $result->error;
		return false;
	}

	/**
	 * [setToken description]
	 * @param string $token [description]
	 */
	public function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * [getToken description]
	 * @return string [description]
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * [getLastError description]
	 * @return string [description]
	 */
	public function getLastError()
	{
		return $this->lastError;
	}
}
