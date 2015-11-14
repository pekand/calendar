<?php
namespace Core;

include '../autoloader.php';

$request = new Request();

$webpage = new WebPage(
    $request
);

echo $webpage->render();
