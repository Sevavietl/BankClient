<?php

namespace BankClient\Domain\Repository;

use BankClient\Domain\Entity\AbstractEntity;

interface RepositoryInterface
{
	public function getById($id);
	public function getAll();
	public function persist(AbstractEntity $entity);
}