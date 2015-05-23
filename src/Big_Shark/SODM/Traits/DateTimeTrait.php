<?php

Trait DateTimeTrait { 

	function getDateTime($key)
    {
        $value = $this->get($key);
        if($value instanceof MongoDate)
        {
            return Carbon::createFromTimeStamp($value->sec);
        }
        return null;
    }

    function setDateTime($key, $value)
    {
        if($value instanceof DateTime)
        {
            $value = new MongoDate($value ->getTimestamp());
        }
        elseif(is_int($value))
        {
            $value = new MongoDate($value);
        }
        elseif(($time = strtotime($value)) !== false)
        {
            $value = new MongoDate($time);
        }

        if( ! ($value instanceof MongoDate))
            throw new Exception('Date format incorrect');

        return $this->set($key, $value);
    }
}