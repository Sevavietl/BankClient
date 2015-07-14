<?php

namespace BankClient\Domain\Entity;

class CreditCard extends AbstractEntity
{
	protected $number;
	protected $expiration;

	public function setNumber($number)
	{
		$this->number = $number;
		return $this;
	}

	public function getNumber()
	{
		return $this->creditCardNumber;
	}

	public function setExpiration($expiration)
	{
		$this->expiration = $expiration;
		return $this;
	}

	public function getExpiration()
	{
		return $this->expiration;
	}

}
