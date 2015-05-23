<?php


class Mapper
{
    /*
    * var Query
    */
    protected $query = [];

    /*
    * var Fields
    */
    protected $fields = [];

    /*
    * var IdentityMap
    */
    protected $identityMap = null;

    /*
      * var MongoCollection
      */
    protected $db = null;

    function __construct(MongoDB $db, IdentityMap $identityMap)
    {
        $this->db = $db;
        $this->identityMap = $identityMap;
    }
    /*
     * @return MongoCollection;
     */
    public function getCollection()
    {
       return $this->db->selectCollection(static::$collection);
    }

    protected function getQuery()
    {
        return $this->query;
    }

    protected function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    protected function resetQuery()
    {
        $this->setQuery([]);
        return $this;
    }

    protected function getFields()
    {
        return $this->fields;
    }

    protected function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    protected function generateMongoDBQuery()
    {   
        return $this->getCollection()->find($this->getQuery(), $this->getFields());
    }

    /**
     * @return Entity
     */
    public function find()
    {
        
        $result = $this->prepare($this->generateMongoDBQuery()->limit(1)); 
        return (isset($result[0]) ? $result[0] : null); 
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->prepare($this->generateMongoDBQuery());
    }

    /**
     * @return array
     */
    public function all()
    {
       $this->resetQuery();
       return $this->get();
    }

    /**
     * @param String $key
     * @param String $value
     * @return self
     */
    public function where($key, $value)
    {
       $this->addQueryParametr('where', $key, $value);
       return $this;
    }

    /**
     * @param String $type
     * @param String $key
     * @param String $value
     * @return self
     */
    public function addQueryParametr($type, $key, $value)
    {
        //TODO: this is test code;
        $this->query[$key] = $value;
        return $this;
    }

    /**
     * @param MongoCursor $cursor
     * @return array
     */
    protected function prepare(MongoCursor $cursor)
    {
        $entityName = static::$entity;
        $array = [];
        foreach ($cursor as $item) {
            if( ! ($entity = $this->identityMap->getEntity(static::$entity, $item['_id'])))
            {
                $entity = new $entityName($item);
                $this->identityMap->setEntity($entity);
            }
            $array[] = $entity;
        }
        return $array;
    }







    /**
     * @param Entity $entity
     * @return Entity
     */
    public function insert(Entity $entity)
    {
        $array = $entity->toArray();
        if(isset($array['_id']))
            throw new Exception('Please remove _id');

        $this->getCollection()->insert($array);
        return $entity->fill($array);
    }

    /**
     * @param Entity $entity
     * @return Entity
     */
    public function save(Entity $entity)
    {
        $array = $entity->toArray();
        $this->getCollection()->save($array);
        return $entity->fill($array);
    }

    /**
     * @param Entity $entity
     * @return Entity
     */
    public function update(Entity $entity)
    {
        $array = $entity->toArray();
        if( ! isset($array['_id']))
            throw new Exception('Object does not contain _id');

        $this->getCollection()->save($array);
        return $entity->fill($array);
    }
}