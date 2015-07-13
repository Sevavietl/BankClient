<?php

namespace BankClient\Persistence\Laravel\Repository;

use BankClient\Domain\Entity\AbstractEntity;
use BankClient\Domain\Repository\RepositoryInterface;
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
		$model = $this->model;

		if ($this->hasIdentity($entity)) {
			$model = $model::find($entity->getId());

			foreach ($data as $propery => $datum) {
				if ($property != 'id') {
					$model->{$property} = $datum;
				}
			}

			$model->save();
		} else {
			$model = $model::create($data);
		}

		$entity = $this->hydrator->insert($entity, $model->toArray());

		return $entity;
	}

	protected function hasIdentity(AbstractEntity $entity)
	{
		return !empty($entity->getId());
	}
}
