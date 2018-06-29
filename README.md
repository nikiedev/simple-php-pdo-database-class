###### Safe and simple PDO Database class with prepared statements
<hr>

## PHP PDO Db Wrapper

### Table of Contents

**[Initialization](#initialization)**  
**[Select Query](#select-query)**  
**[Insert Query](#insert-query)**  
**[Insert Multiple Query](#insert-multiple-query)**  
**[Update Query](#update-query)**  
**[Delete Query](#delete-query)**  
**[Create database](#create-database)**  
**[Truncate table](#truncate-table)**  
**[Drop database](#drop-database)**  
**[Drop table](#drop-table)**  

## Support Me

This software is developed during my free time and I will be glad if somebody will support me.

Everyone's time should be valuable, so please consider donating.

[Donate with paypal](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=a%2ebutenka%40gmail%2ecom&lc=DO&item_name=Db&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted)

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
// simple way (you need to change params in the __constructor to yours at first):
$db = new Db();
```
Advanced initialization:
```php
// Advanced initialization, whith params:
$db = new Db('driver', 'host', 'username', 'password', 'databaseName', 'charset');
```

You can add a prefix of your database:

```php
$db->setPrefix ('my_');
```

### Objects mapping
dbObject.php is an object mapping library built on top of Db to provide model representation functionality.
See <a href='dbObject.md'>dbObject manual for more information</a>

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
$selectAll = $db->select('article');
```

or select just one row

```php
$selectAll = $db->select('article', ['id' => 1]);
```

### Delete Query
```php
$db->where('id', 1);
if($db->delete('users')) echo 'successfully deleted';
```

### Create Database
```php
$db->where('id', 1);
if($db->delete('users')) echo 'successfully deleted';
```

### Create Table
```php
$db->where('id', 1);
if($db->delete('users')) echo 'successfully deleted';
```

### Truncate Table
```php
$db->truncateTable('article');
```
example of use:
```php
if(truncateTable('article')) 
{
    echo 'Table article successfully cleared';
}
```

### Drop Database
```php
$db->dropDatabase('articles');
```
example of use:
```php
if(dropDatabase('articles')) 
{
    echo 'Table articles successfully deleted';
}
```

### Drop Table
```php
$db->dropTable('article');
```
example of use:
```php
if(dropTable('article')) 
{
    echo 'Table article successfully deleted';
}
```
