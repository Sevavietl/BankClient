<?php

namespace BankClient\Persistance\Hydrator;

use BankClient\Domain\Entity\AbstractEntity;

interface HydratorInterface
{
	public function extract(AbstractEntity $entity);
	public function insert(AbstractEntity $entity, $data);
}
