<?php

namespace BankClient\Persistence\Laravel\Repository;

use BankClient\Domain\Entity\AbstractEntity;
use BankClient\Persistance\Hydrator\HydratorInterface;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
implements RepositoryInterface
{
	protected $model;
	protected $hydrator;

	public function __construct(
		Model $model,
		HydratorInterface $hydrator
	) {
		$this->model = $model;
		$this->hydrator = $hydrator;
	}

	public function getById($id)
	{
		$model = $this->model;
		$result = $model::find($id);

		return $result ? $result : false;
	}

	public function getAll()
	{
		$model = $this->model;
		$resultSet = $model::all();

		return $resultSet;
	}

	public function persist(AbstractEntity $entity)
	{
		$data = $this->hydrator->extract($entity);

		if ($this->hasIdentity($entity)) {
			$model = $this->model;
			$this->gateway->update($data, ['id' => $entity->getId()]);
		} else {
			$this->gateway->insert($data);
			$entity->setId($this->gateway->getLastInsertValue());
		}

		return $this;
	}

	protected function hasIdentity(AbstractEntity $entity)
	{
		return !empty($entity->getId());
	}
}
