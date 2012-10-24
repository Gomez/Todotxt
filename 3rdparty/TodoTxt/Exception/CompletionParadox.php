<?php

namespace TodoTxt\Exception;

class CompletionParadox extends \Exception
{
    public function __construct() {
        $this->message = "The task was completed before it was created.";
    }
}