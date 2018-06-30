`Безопасный и простой PHP PDO класс для работы с базой данных`
<hr>

## PHP PDO Db Wrapper with prepared statements


### Documentation

`English`

See <a href='HelpEN.md'>English manual</a> for more information

`Homepage`

Go <a href='https://github.com/nikiedev/simple-php-pdo-database-class'>back</a> to the main page

### Table of Contents

**[Initialization](#initialization)**  
**[Select Query](#select-query)**  
**[Insert Query](#insert-query)**  
**[Insert Multiple Query](#insert-multiple-query)**  
**[Update Query](#update-query)**  
**[Delete Query](#delete-query)**  
**[Create database](#create-database)**  
**[Create table](#create-table)**  
**[Truncate table](#truncate-table)**  
**[Drop database](#drop-database)**  
**[Drop table](#drop-table)**  


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
$db = new Db('driver', 'host', 'username', 'password', 'databaseName', 'charset');
```

You can add a prefix of your database:

```php
$db->setPrefix ('my_');
```

### Insert Query
Simple example
```php
$data = Array ("login" => "admin",
               "firstName" => "John",
               "lastName" => 'Doe'
);
$id = $db->insert ('users', $data);
if($id)
    echo 'user was created. Id=' . $id;
```

Insert with functions use
```php
$data = Array (
	'login' => 'admin',
    'active' => true,
	'firstName' => 'John',
	'lastName' => 'Doe',
	'password' => $db->func('SHA1(?)',Array ("secretpassword+salt")),
	// password = SHA1('secretpassword+salt')
	'createdAt' => $db->now(),
	// createdAt = NOW()
	'expires' => $db->now('+1Y')
	// expires = NOW() + interval 1 year
	// Supported intervals [s]econd, [m]inute, [h]hour, [d]day, [M]onth, [Y]ear
);

$id = $db->insert ('users', $data);
if ($id)
    echo 'user was created. Id=' . $id;
else
    echo 'insert failed: ' . $db->getLastError();
```

Insert with on duplicate key update
```php
$data = Array ("login" => "admin",
               "firstName" => "John",
               "lastName" => 'Doe',
               "createdAt" => $db->now(),
               "updatedAt" => $db->now(),
);
$updateColumns = Array ("updatedAt");
$lastInsertId = "id";
$db->onDuplicate($updateColumns, $lastInsertId);
$id = $db->insert ('users', $data);
```

### Insert Multiple Query
Insert multiple datasets at once
```php
$data = Array(
    Array ("login" => "admin",
        "firstName" => "John",
        "lastName" => 'Doe'
    ),
    Array ("login" => "other",
        "firstName" => "Another",
        "lastName" => 'User',
        "password" => "very_cool_hash"
    )
);
$ids = $db->insertMulti('users', $data);
if(!$ids) {
    echo 'insert failed: ' . $db->getLastError();
} else {
    echo 'new users inserted with following id\'s: ' . implode(', ', $ids);
}
```

If all datasets only have the same keys, it can be simplified
```php
$data = Array(
    Array ("admin", "John", "Doe"),
    Array ("other", "Another", "User")
);
$keys = Array("login", "firstName", "lastName");

$ids = $db->insertMulti('users', $data, $keys);
if(!$ids) {
    echo 'insert failed: ' . $db->getLastError();
} else {
    echo 'new users inserted with following id\'s: ' . implode(', ', $ids);
}
```

### Update Query
```php
$data = Array (
	'firstName' => 'Bobby',
	'lastName' => 'Tables',
	'editCount' => $db->inc(2),
	// editCount = editCount + 2;
	'active' => $db->not()
	// active = !active;
);
$db->where ('id', 1);
if ($db->update ('users', $data))
    echo $db->count . ' records were updated';
else
    echo 'update failed: ' . $db->getLastError();
```

`update()` also support limit parameter:
```php
$db->update ('users', $data, 10);
// Gives: UPDATE users SET ... LIMIT 10
```

### Select Query
select title and content columns 
```php
$selectCustomFields = $db->select(['article', ['title, content']], null, '3', '0', ['id' => 'ASC']);
```
select all from the table
```php
$selectAll = $db->select('tableName');
```

or select just one row

```php
$select = $db->select('tableName', ['id' => 1]);
```
example of use:
```php
$article = $db->select('article', ['id' => 1])) 
foreach ($article as $k => $v)
{
    echo '<p>' . $k . ': ' . $v . '</p>';
}
```

### Delete Query
```php
$db->delete('id', 1);
```
example of use:
```php
if($db->delete('article', ['id' => 1])) 
{
    echo 'Row deleted successfully!';
}
```

### Create Database
```php
$db->createDatabase('articles');
```
example of use:
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
example of use:
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

### Truncate Table
```php
$db->truncateTable('article');
```
example of use:
```php
if($db->truncateTable('article')) 
{
    echo 'Table article successfully cleared!';
}
```

### Drop Database
```php
$db->dropDatabase('articles');
```
example of use:
```php
if($db->dropDatabase('articles')) 
{
    echo 'Table articles successfully deleted!';
}
```

### Drop Table
```php
$db->dropTable('article');
```
example of use:
```php
if($db->dropTable('article')) 
{
    echo 'Table article successfully deleted!';
}
```
