<?php

namespace BankClient\Domain\Repository;

use BankClient\Domain\Entity\AbstractEntity;

interface RepositoryInterface
{
	public function getById($id);
	public function getBy(array $criterias);
	public function getAll();
	public function persist(AbstractEntity $entity);
	public function begin();
	public function commit();
}
