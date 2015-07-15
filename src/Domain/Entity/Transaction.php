<?php

namespace BankClient\Domain\Entity;

class Transaction extends AbstractEntity
{
	/**
	 * [$firstName description]
	 * @var string
	 */
	protected $firstName;
	/**
	 * [$lastName description]
	 * @var string
	 */
	protected $lastName;
	/**
	 * [$cardNumber description]
	 * @var string
	 */
	protected $cardNumber;
	/**
	 * Expiration date mm/yy
	 * @var string
	 */
	protected $cardExpiration;
	/**
	 * [$amount description]
	 * @var integer
	 */
	protected $amount;
	/**
	 * [$status description]
	 * @var string
	 */
	protected $status;

	const STATUS_NEW = 'new';
	const STATUS_PENDING = 'pending';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';

	/**
	 * [setFirstName description]
	 * @param string $firstName [description]
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
		return $this;
	}

	/**
	 * [getFirstName description]
	 * @return string [description]
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * [setLastName description]
	 * @param string $lastName [description]
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}

	/**
	 * [getLastName description]
	 * @return string [description]
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

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

	/**
	 * [setAmount description]
	 * @param integer $amount [description]
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * [getAmount description]
	 * @return integer [description]
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * [setStatus description]
	 * @param string $status [description]
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * [getStatus description]
	 * @return string [description]
	 */
	public function getStatus()
	{
		return $this->status;
	}
}
