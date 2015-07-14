<?php

namespace BankClient\Domain\Entity;

class Card extends AbstractEntity
{
	protected $cardNumber;
	protected $cardExpiration;

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
}
