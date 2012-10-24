<?php

require_once __DIR__ . "/Task.php";

namespace TodoTxt;

class TodoList implements \ArrayAccess, \Countable, \SeekableIterator, \Serializable
{
    public static $lineSeparator = "\n";
    
    protected $tasks = array();
    protected $position = 0;

    public function __construct(array $tasks = null) {
        $this->rewind();
        
        if (!is_null($tasks)) {
            $this->addTasks($tasks);
        }
    }
    
    public function addTask($task) {
        if (!($task instanceof $task)) {
            $task = new Task((string) $task);
        }
        $this->tasks[] = $task;
    }
    
    public function addTasks(array $tasks) {
        foreach ($tasks as $task) {
            $this->addTask($task);
        }
    }
    
    /**
     * Parses tasks from a newline separated string
     * @param string $taskFile A newline-separated list of tasks.
     */
    public function parseTasks($taskFile) {
        foreach (explode(self::$lineSeparator, $taskFile) as $line) {
            $line = trim($line);
            if (strlen($line) > 0) {
                $this->addTask($line);
            }
        }
    }
    
    public function getTasks() {
        return $this->tasks;
    }
    
    public function sort($mode = 0) {
        return;
    }
    
    public function __toString() {
        $this->sort();
        
        $file = "";
        foreach ($this->tasks as $task) {
            $file .= $task . self::$lineSeparator;
        }
        
        return trim($file);
    }
    
    public function offsetExists($offset) {
        return isset($this->tasks[$offset]);
    }
    
    public function offsetGet($offset) {
        return isset($this->tasks[$offset]) ? $this->tasks[$offset] : null;
    }
    
    public function offsetSet($offset, $value) {
        $this->tasks[$offset] = $value;
    }
    
    public function offsetUnset($offset) {
        unset($this->tasks[$offset]);
    }
    
    public function serialize() {
        return serialize($this->tasks);
    }
    
    public function unserialize($tasks) {
        $this->tasks = unserialize($tasks);
    }
    
    public function seek($position) {
        $this->position = $position;
        if (!$this->valid()) {
            throw new \OutOfBoundsException("Cannot seek to position $position.");
        }
    }
    
    public function current() {
        return $this->tasks[$this->position];
    }
    
    public function key() {
        return $this->position;
    }
    
    public function next() {
        ++$this->position;
    }
    
    public function rewind() {
        $this->position = 0;
    }
    
    public function valid() {
        return isset($this->tasks[$this->position]);
    }
    
    public function count() {
        return count($this->tasks);
    }
}
