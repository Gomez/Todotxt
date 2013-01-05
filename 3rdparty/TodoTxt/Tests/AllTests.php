<?php

namespace TodoTxt\Tests;

require_once __DIR__ . "/Task.php";

class AllTests
{   
    public static function suite() {
        // Autoloader for classes - 1 level above the TodoTxt lib dir.
        set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../../");
        spl_autoload_register(function($name) {
            require_once str_replace(array("_", "\\"), "/", $name) . ".php";
        });
        
        $suite = new \PHPUnit_Framework_TestSuite("TodoTxt");
        $suite->addTestSuite('TodoTxt\Tests\TaskTest');
        return $suite;
    }
}