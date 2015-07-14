<?php

namespace BankClient\Domain\Entity;

class Transaction extends AbstractEntity
{
	protected $firstName;
	protected $lastName;
	protected $cardNumber;
	protected $cardExpiration;
	protected $amount;
	protected $status;

	const STATUS_NEW = 'new';
	const STATUS_PENDING = 'pending';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function setCardNumber($cardNumber)
	{
		$this->cardNumber = $cardNumber;
		return $this;
	}

	public function getCardNumber()
	{
		return $this->cardNumber;
	}

	public function setCardExpiration($cardExpiration)
	{
		$this->cardExpiration = $cardExpiration;
		return $this;
	}

	public function getCardExpiration()
	{
		return $this->cardExpiration;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	public function getStatus()
	{
		return $this->status;
	}
}
