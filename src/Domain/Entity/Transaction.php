<?php

namespace BankClient\Domain\Entity;

class Transaction extends AbstractEntity
{
	protected $firstName;
	protected $lastName;
	protected $creditCardNumber;
	protected $creditCardExpiration;
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

	public function getFirstName($firstName)
	{
		return $this->firstName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getLastName($lastName)
	{
		return $this->lastName;
	}

	public function setCreditCardNumber($creditCardNumber)
	{
		$this->creditCardNumber = $creditCardNumber;
		return $this;
	}

	public function getCreditCardNumber($creditCardNumber)
	{
		return $this->creditCardNumber;
	}

	public function setCreditCardExpiration($creditCardExpiration)
	{
		$this->creditCardExpiration = $creditCardExpiration;
		return $this;
	}

	public function getCreditCardExpiration($creditCardExpiration)
	{
		return $this->creditCardExpiration;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	public function getStatus($status)
	{
		return $this->status;
	}


}
