<?php

function __autoload($name) {
    //echo $name.'<br/>';
    if (class_exists($name)) {
       return;
    }

    chdir(dirname(__FILE__));

    $name = str_replace('\\', '/', $name);

    if (file_exists(dirname(__FILE__)."/$name.php")) {
        include dirname(__FILE__)."/$name.php";
        return;
    }

    throw new Exception("Unable to load class $name.");
}
