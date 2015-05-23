<?php

class IdentityMap 
{

	protected $container = [];

	public function setEntity(Entity $entity)
	{
		$this->container[get_class($entity)][(string)$entity->getId()] = $entity;
		return $this;
	}

	public function getEntity($class, $id)
	{
		if(isset($this->container[$class][(string)$id]))
		{
			$entity = $this->container[$class][(string)$id];
		}
		else
		{
			$entity = null;
		}
		return $entity;
	}
}