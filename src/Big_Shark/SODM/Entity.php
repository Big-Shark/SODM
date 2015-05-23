+<?php


use Carbon\Carbon;

class Entity
{
    protected $fields = [];
    protected $attributes = [];

    function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    function fill($attributes)
    {
        $this->attributes = $attributes;
    }

    function toArray()
    {
        return $this->attributes;
    }

    function get($key)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;
    }

    function getId()
    {
        $id = $this->get('_id');
        if( ! ($id instanceof MongoId))
        {
            throw new Exception("id does not exist");
        }
        return $id;
    }

    function set($key, $value)
    {
        if( ! in_array($key, $this->fields))
         throw new Exception("Field doesn't exist");

        $this->attributes[$key] = $value;
        return $this;
    }    
}