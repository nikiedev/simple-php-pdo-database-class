<?php

use lib\Db;

spl_autoload_extensions('.class.php');
spl_autoload_register();

/*
$db_options = [
    'user' => 'root',
    'pass' => '',
    'db' => 'articles',
    'host' => 'localhost'
];

$db_safe = new SafeMySQL($db_options);

$all = $db_safe->getAll("SELECT * FROM `article`");

foreach ($all as $rows) {
	echo '<p>';
    foreach ($rows as $col_k => $col_v) {
	    echo $col_k . ': ' . $col_v . '<br>';
    }
	echo '</p>';
}

echo '<hr>';


$db = new MysqliDb('localhost', 'root', '', 'articles');

if ($db) {
	$res = $db->get('article', 3);
echo $res;
	//var_dump($res);
}
*/






//$res = $db->select(['id, title, content'], 'article');

	//$res3 = $db3->array_load_all('article');



	?>


<?php

//$db = new Db();
//$db->connectDatabase('articles');
//$db->select('article'); select all
//$selectAllFields = $db->select([['title, content'], ['article']], null, '3', '0', ['id' => 'ASC']);

//$selectCustomFields = $db->select(['article', ['title, content']], null, '3', '0', ['id' => 'ASC']);

//$insertOneRow = $db->insert('article', ['id' => null, 'title' => 'Заголовок № 10', 'content' => 'Тут текст записи № 10.']);


// $checkConnection = $db->connectionStatus();
//$insertMultipleRows = $db->insertMultiple(
//        'article',
//        ['id, title, content'],
//        [
//            [29, 'title №13', 'content №13'],
//	        [28, 'title №14', 'content №14']
//        ]
//);
//not tested
/*$db->createTable("CREATE TABLE IF NOT EXISTS users (
             id INT(11) NOT NULL AUTO_INCREMENT,
             firstName VARCHAR(255) NOT NULL,
             lastName VARCHAR(255) NOT NULL,
             email VARCHAR(255) NOT NULL,
             PRIMARY KEY (id))"
);*/

// works
//$db->dropDatabase('comments');

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<!---->
<?php //foreach ($res as $r): ?>
<?php //foreach ($r as $i): ?>
<?php //echo $i . ' '; ?>
<?php //endforeach; ?>
<?php //echo '<br><br>'; ?>
<?php //endforeach; ?>

<?php
echo '<br><hr>';

// работает
var_dump($selectAllFields);

echo '<br><hr>';

// работает
// var_dump($selectCustomFields);

echo '<br><hr>';

// работает
//var_dump($insertOneRow);

echo '<br><hr>';

// работает, вернет bool
//var_dump($insertMultipleRows);

echo '<br><hr>';

// работает, вернет bool
// var_dump($checkConnection);


?>

</body>
</html>
