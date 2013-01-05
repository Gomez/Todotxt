<?php

namespace TodoTxt\Exception;

class EmptyString extends \Exception
{
    public function __construct() {
        $this->message = "Cannot parse an empty string as a task.";
    }
}