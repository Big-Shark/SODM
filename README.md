H1.SODM - Simple object data mapper

--------

Скорость, легкость и удобство использования, вот основные задачи.

Сразу небольшой пример работы.

Создание обьекта и добавления его в базу.
```
$mapper = new BookMapper($db, $identityMap);

$book = new Book(['title' =>'Book']);
$mapper->insert($book);
```
или 
```
$mapper = new BookMapper($db, $identityMap);

$book = new Book();
$book->setTitle('Book');
$mapper->insert($book);
```

Все просто, и тут нет магии, функция setTitle создается генератором, что помогает избежать многих проблем.

Давайте посмотрим как работают запросы.

Получаем все записи
```
$mapper = new BookMapper($db, $identityMap);

$allBooks = $mapper->all();
foreach($allBooks as $book)
{
    echo $book->getTitle();
}
```

Получаем только те записи где тайтл равен SuperBook
```
$mapper = new BookMapper($db, $identityMap);

$books = $mapper->whereTitle('SuperBook')->get();
foreach($books as $book)
{
    echo $book->getTitle();
}
```