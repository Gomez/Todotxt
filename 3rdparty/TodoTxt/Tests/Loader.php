<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../../");
function __autoload($name) {
    require_once str_replace(array("_", "\\"), "/", $name) . ".php";
}

foreach (array(__DIR__ . "/list", __DIR__ . "/test.txt") as $path) {
    print $path . "\n";
    $loader = new TodoTxt\Loader\LocalLoader($path);
    $list = $loader->pull();
    var_dump($loader);
    print count($list) . "\n";
    foreach ($list as $l) {
        print $l . "\n";
    }
}