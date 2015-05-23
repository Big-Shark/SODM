<?php

class BaseBook extends Entity
{
	use DateTimeTrait;

    protected $fields = ['title'];


    function getTitle()
    {
        return $this->get('title');
    }

    function setTitle($value)
    {
        return $this->set('title', $value);
    }

    function getCreatedAt()
    {
        return $this->getDateTime('created_at');
    }

    function setCreatedAt($value)
    {
        return $this->setDateTime('created_at', $value);
    }
}