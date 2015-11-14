<?php
namespace Core;

use Pages\Note\Note;

include '../autoloader.php';

$request = new Request(@$_REQUEST['u']);

$webpage = new WebPage(
    $request
);

echo $webpage->render();
