<?php

namespace BankClient\Persistance\Hydrator;

use BankClient\Persistance\Hydrator\HydratorInterface;

use BankClient\Domain\Entity\AbstractEntity;

class SimpleHydrator implements HydratorInterface
{
	public function extract(AbstractEntity $entity)
	{
		$result = [];

		$reflection = new \ReflectionClass($entity);
		$properties = $reflection->getProperties(ReflectionProperty::IS_PROTECTED);

		foreach ($properties as $property) {
			if (
				null != $property ->getValue()
				&& 'id' != $property->getName()
			) {
		    	$result[snake_case($property)] = $entity->get{ucfirst($property->getName())};
			}
		}

		return $result;
	}

	public function insert(AbstractEntity $entity, $data)
	{
		$reflection = new \ReflectionClass($entity);

		foreach ($data as $property => $datum) {
			if ($reflection->hasProperty($property)) {
				$entity->set{ucfirst($property)}($datum);
			}
		}

		return $entity;
	}
}
