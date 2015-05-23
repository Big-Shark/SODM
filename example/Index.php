<?php

include __DIR__.'/../src/Big_Shark/SODM/Entity.php';
include __DIR__.'/../src/Big_Shark/SODM/Mapper.php';
include __DIR__.'/../src/Big_Shark/SODM/UoW.php';
include __DIR__.'/../src/Big_Shark/SODM/Traits/DateTimeTrait.php';
include __DIR__.'/Book.php';
include __DIR__.'/BookMapper.php';


$m = new MongoClient();
$db = $m->selectDB('odm');

$UoW = new UoW;
$mapper = new BookMapper($db, $UoW);

$book = new Book(['title' =>'Book'.rand(1,100)]);
$book->setCreatedAt(time());
$mapper->insert($book);

$allBooks = $mapper->all();
foreach($allBooks as $book)
{
    dump($allBooks);
}

/*
echo '-------------------------'.PHP_EOL;

$book = $mapper->whereTitle('Book15')->find();
dump($book);
$book->setTitle('Test UoW');

$books = $mapper->whereTitle('Book15')->find();
dump($book);

dump($UoW);
*/