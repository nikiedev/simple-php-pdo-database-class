`Safe and simple PDO Database class. English documentation.`
<hr>

## PHP: PDO Db Wrapper with prepared statements


### Other links

`Russian`

See <a href='HelpRU.md'>Russian manual</a> for more information

`Homepage`

Go <a href='https://github.com/nikiedev/simple-php-pdo-database-class'>back</a> to the main page

### Table of Contents

**[Installation](#installation)**  
**[Initialization](#initialization)**  
**[Select](#select)**  
**[Select Join](#select-join)**  
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

- Import Db.class.php into your project, and require it:

```php
require_once 'Db.class.php';
```

or you can use autoload:

```php
spl_autoload_extensions('.class.php');
spl_autoload_register();
```

- Import the namespace to the file where the class is used:

```php
use lib\Db;
```

### Initialization

Simple initialization with utf8 charset set by default:
```php
// simple way (you need to change params in the 'constructor' at first):
$db = new Db();
```
Advanced initialization:
```php
// initialization with params:
$db = new Db('driver', 'host', 'username', 'password', 'databaseName', 'charset', 'prefix');
```

### Select

select all from the table *table1*
```php
$db->select('table1');
```
select *1* row from the table *table1* where *id* == *1*
```php
$db->select('table1', ['id' => 1]);
```
select columns *col1* and *col2* from the table *table1*
```php
$db->select(['table1', ['col1', 'col2']]);
```
select columns *col1* and *col2* from the table *table1* with limit start from *0* to *3* sorted by ascending
```php
$db->select(['table1', ['col1', 'col2']], '', '3', '0', ['id' => 'ASC']);
```

##### Examples of use

```php
// select 1 article where id == 1
$article = $db->select('article', ['id' => 1])) 
// show
foreach ($article as $k => $v)
{
    echo '<p>' . $k . ': ' . $v . '</p>';
}

// select columns title and content from the table article
$selectCustomCols = $db->select(['article', ['title', 'content']]);
// show
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

### Select Join

select data from tables *article*, *authors*, *tags*
```php
$db->selectJoin([
	'article' => [
		'id AS artid', 'title AS atrtitle', 'content', 'image', 'author_id', 'tag_id', 'published'
	],
	'authors' => [
		'id AS autid', 'name'
	],
	'tags' => [
		'id AS tgid', 'title AS tgtitle'
	]
], [
	'author_id', 'tag_id'
]);
```
to avoid conflicts for columns *id* and *title* give aliases

### Insert

insert one row into the table *table1* with columns *id*, *title*, *content*
```php
$db->insert('table1', [
        'id' => null,
        'title' => 'Заголовок 1',
        'content' => 'Тут текст записи № 1.'
    ]
);
```

### Insert Multiple

insert several rows (if id PRIMARY KEY - we can use null)
```php
$db->insertMultiple(
        'table1',
        ['id, title, content'],
        [
            [1, 'title 1', 'Text of the article 1'],
            [2, 'title 2', 'Text of the article 2']
        ]
);
```

### Last Insert Id

method returns last inserted id of the query, that was made before
```php
$lastInsertId = $db->lastInsertId();
```

### Update

update column *col1* in the table *table1*
```php
$db->update('table1', ['col1' => 'Article 1 (updated)'], ['id' => 9]);
```

update all columns *col1* in the table *table1* where *value* == *Title № 10*
```php
$db->update('table1', ['col1' => 'Title № 10++ (updated)'], ['col1' => 'Title № 10']);
```

##### Example of use

```php
$updateRow = $db->update('article', ['title' => 'Article 1 (updated text here)'], ['id' => 10]);
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

##### Example of use

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

##### Example of use

```php
if($db->createDatabase('articles')) 
{
    echo 'Database articles created successfully!';
}
```

### Create Table

if we write in such a way:
```php
$db->createTable('users', [
        'firstName' => 'VARCHAR(255) NOT NULL',
        'lastName' => 'VARCHAR(255) NOT NULL',
        'email' => 'VARCHAR(255) NOT NULL'
    ]
);
```
the final query will be:
```sql
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Optimize Table

```php
$db->optimizeTable('table1');
```

##### Example of use

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

##### Example of use

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

##### Example of use

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

##### Example of use

```php
if($db->dropTable('article')) 
{
    echo 'Table article successfully deleted!';
}
```

**[To Top](#other-links)**  