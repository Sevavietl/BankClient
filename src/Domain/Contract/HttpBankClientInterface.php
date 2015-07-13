<?php

namespace BankClient\Domain\Contract;

use BankClient\Domain\Entity\User;
use BankClient\Domain\Entity\CreditCard;

interface HttpBankClientInterface
{
	public function setUser(User $user);
	public function setCreditCard(CreditCard $creditCard);
	public function authenticate();
	public function bill($amount);
}
