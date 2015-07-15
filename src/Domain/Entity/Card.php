<?php

namespace BankClient\Domain\Entity;

class Card extends AbstractEntity
{
	/**
	 * [$cardNumber description]
	 * @var string
	 */
	protected $cardNumber;
	/**
	 * [$cardExpiration description]
	 * @var string
	 */
	protected $cardExpiration;

	/**
	 * [setCardNumber description]
	 * @param string $cardNumber [description]
	 */
	public function setCardNumber($cardNumber)
	{
		$this->cardNumber = $cardNumber;
		return $this;
	}

	/**
	 * [getCardNumber description]
	 * @return string [description]
	 */
	public function getCardNumber()
	{
		return $this->cardNumber;
	}

	/**
	 * [setCardExpiration description]
	 * @param string $cardExpiration [description]
	 */
	public function setCardExpiration($cardExpiration)
	{
		$this->cardExpiration = $cardExpiration;
		return $this;
	}

	/**
	 * [getCardExpiration description]
	 * @return string [description]
	 */
	public function getCardExpiration()
	{
		return $this->cardExpiration;
	}
}
