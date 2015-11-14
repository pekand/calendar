<?php

include "database.php";

$db = new Database('test', 'root', 'root', '127.0.0.1');

$db->query('CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL,
  `data` text NOT NULL
)', array(), false);

if (($error = $db->getError()) !== null) {
    var_dump($error);
}

$db->begin();
$db->query('DELETE FROM  test WHERE id = :id', array(':id'=>2), false);
$db->query('DELETE FROM  test WHERE id = :id', array(':id'=>3), false);
$db->end();

if (($error = $db->getError()) !== null) {
    var_dump($error);
}

$db->query('insert into test (data) values (:value)', array('value' => 'xxx'), false);
if (($error = $db->getError()) !== null) {
    var_dump($error);
} else {
    echo "last id:".$db->lastId();
}

$result = $db->query('select * from test');
var_dump($result);
