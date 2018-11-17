`Безопасный и простой PDO класс для работы с базой данных. Русская документация.`
<hr>

## PHP: PDO Db Wrapper with prepared statements


### Other links

`English`

Смотрите <a href='HelpEN.md'>Английскую документацию</a> чтобы получить больше информации

`Homepage`

Вернуться <a href='https://github.com/nikiedev/simple-php-pdo-database-class'>назад</a> на главную страницу

### Содержание

**[Installation](#installation)**  
**[Initialization](#initialization)**  
**[Select](#select)**  
**[Insert](#insert)**  
**[Insert Multiple](#insert-multiple)**  
**[Last Insert Id](#last-insert-id)**  
**[Update](#update)**  
**[Delete](#delete)**  
**[Create Database](#create-database)**  
**[Create Table](#create-table)**  
**[Optimize Table](#optimize-table)**  
**[Truncate Table](#truncate-table)**  
**[Drop Database](#drop-database)**  
**[Drop Table](#drop-table)**  


### Installation

- Подключите Db.class.php к вашему проекту следующим образом:

```php
require_once 'Db.class.php';
```

или же вы можете использовать автозагрузку:

```php
spl_autoload_extensions('.class.php');
spl_autoload_register();
```

- Подключите пространство имен в файл где вы используете класс:

```php
use lib\Db;
```

### Initialization

Простая инициализация: создаем подключение к базе с кодировкой utf8 по умолчанию:
```php
// вызываем конструктор по умолчанию (необходимо сперва изменить агрументы функций в 'конструкторе' в самом классе):
$db = new Db();
```
Расширенная инициализация:
```php
// вызываем конструктор с параметрами:
$db = new Db('driver', 'host', 'username', 'password', 'databaseName', 'charset', 'prefix');
```

### Select

выбираем все из таблицы *table1*
```php
$db->select('table1');
```
выбираем *1* строку из таблицы *table1* где *id* == *1*
```php
$db->select('table1', ['id' => 1]);
```
выбираем колонки *col1* и *col2* из таблицы *table1*
```php
$db->select(['table1', ['col1', 'col2']]);
```
выбираем колонки *col1* и *col2* из таблицы *table1* с лимтом от *0* до *3* с сортировкой по возростанию
```php
$db->select(['table1', ['col1', 'col2']], '', '3', '0', ['id' => 'ASC']);
```

##### Примеры использования

```php
// выбираем 1 материал у которого id == 1
$article = $db->select('article', ['id' => 1])) 
// отображаем
foreach ($article as $k => $v)
{
    echo '<p>' . $k . ': ' . $v . '</p>';
}

// выбираем колонки title и content из таблицы article
$selectCustomCols = $db->select(['article', ['title', 'content']]);
// отображаем
foreach ($selectCustomCols as $rows)
{
    echo '<p>';
    foreach ($rows as $col_k => $col_v)
    {
         echo $col_k . ': ' . $col_v . '<br>';
    }
    echo '</p>';
}
```

### Insert

вставка строки в таблицу *table1* с колонками *id*, *title*, *content*
```php
$db->insert('table1', [
        'id' => null,
        'title' => 'Заголовок 1',
        'content' => 'Тут текст записи № 1.'
    ]
);
```

### Insert Multiple

вставка нескольких строк (если id PRIMARY KEY - можно использовать null)
```php
$db->insertMultiple(
        'table1',
        ['id, title, content'],
        [
            [1, 'Заголовок 1', 'Текст статьи 1'],
            [2, 'Заголовок 2', 'Текст статьи 2']
        ]
);
```

### Last Insert Id

метод возвращает последний id запроса, что был выполнен ранее
```php
$lastInsertId = $db->lastInsertId();
```

### Update

обновление колонки *col1* в таблице *table1*
```php
$db->update('table1', ['col1' => 'Материал 1 (обновленный)'], ['id' => 9]);
```

обновление всех колонок *col1* в таблице *table1* где *значение* == *Заголовок № 10*
```php
$db->update('table1', ['col1' => 'Заголовок № 10++ (updated)'], ['col1' => 'Заголовок № 10']);
```

##### Пример использования

```php
$updateRow = $db->update('article', ['title' => 'Материал 1 (это обновленный текст)'], ['id' => 10]);
if ($updateRow) {
    echo 'updated ' . $updateRow . ' row(s) successfully!';
} else {
    echo 'update failed!';
}
```

### Delete

```php
$db->delete('table1', ['id' => 1]);
```

##### Пример использования

```php
if($db->delete('article', ['id' => 1])) 
{
    echo 'Row deleted successfully!';
}
```

### Create Database

```php
$db->createDatabase('database1');
```

##### Пример использования

```php
if($db->createDatabase('articles')) 
{
    echo 'Database articles created successfully!';
}
```

### Create Table

```php
$db->createTable("CREATE TABLE IF NOT EXISTS users (
             id INT(11) NOT NULL AUTO_INCREMENT,
             firstName VARCHAR(255) NOT NULL,
             lastName VARCHAR(255) NOT NULL,
             email VARCHAR(255) NOT NULL,
             PRIMARY KEY (id))"
);
```

##### Пример использования

```php
$sql = "CREATE TABLE IF NOT EXISTS users (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    firstName VARCHAR(255) NOT NULL,
                    lastName VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id))";
if($db->createTable($sql)) 
{
    echo 'Table users created successfully!';
}
```

### Optimize Table

```php
$db->optimizeTable('table1');
```

##### Пример использования

```php
if($db->optimizeTable('article')) 
{
    echo 'Table article successfully optimized!';
}
```

### Truncate Table

```php
$db->truncateTable('table1');
```

##### Пример использования

```php
if($db->truncateTable('article')) 
{
    echo 'Table article successfully cleared!';
}
```

### Drop Database

```php
$db->dropDatabase('database1');
```

##### Пример использования

```php
if($db->dropDatabase('articles')) 
{
    echo 'Table articles successfully deleted!';
}
```

### Drop Table

```php
$db->dropTable('table1');
```

##### Пример использования

```php
if($db->dropTable('article')) 
{
    echo 'Table article successfully deleted!';
}
```

**[Наверх](#other-links)**  