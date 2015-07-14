<?php

namespace BankClient\Domain\Contract;

use BankClient\Domain\Entity\User;
use BankClient\Domain\Entity\Card;

interface HttpBankClientInterface
{
	public function setUser(User $user);
	public function setCard(Card $card);
	public function authenticate();
	public function bill($amount);
}
