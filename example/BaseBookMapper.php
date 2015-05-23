<?php


class BaseBookMapper extends Mapper
{
    /*
    * var Book
    */
    static $entity = Book::class;
    /*
    * var Collection Name
    */
    static $collection = 'Books';

    /**
     * @param String $title Title
     * @return self
     */
    public function whereTitle($title)
    {
    	return $this->where('title', $title);
    }
}