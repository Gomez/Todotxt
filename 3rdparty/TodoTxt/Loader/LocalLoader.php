<?php

namespace TodoTxt\Loader;

class LocalLoader
{
    const LIST_NAME = "todo.txt";
    const LIST_DONE = "done.txt";
    const LIST_BACKUP = "todo.txt.bak";
    
    /**
     * The strategy to use when taking hashes of the file contents.
     *
     * The normalise strategy takes a hash of the raw file's contents.
     * This means that when you later come to push(), even if there are
     * no changes to the list, the normalised output by
     * TodoList::__toString() might result in a slightly different
     * output (e.g. some whitespace).
     *
     * A conservative strategy uses a hash of the normalised list to
     * start with, so if there are no formatting differences they won't
     * be updated.
     *
     * This is a fairly miniscule optimisation, however if two editors
     * are used on one file and both output different formats, using
     * conservative mode might prevent a few substance-less pushes.
     *
     * Because I am a markup fiend the normalising strategy is used by
     * default.
     * @TODO: Explain simply.
     * @TODO: Find better names for the strategies.
     */
    const STRATEGY_CONSERVATIVE = 1;
    const STRATEGY_NORMALISE = 2;
    protected $strategy;
    public static $defaultStrategy = self::STRATEGY_NORMALISE;
    
    protected $path;
    protected $standalone;
    protected $lastHash;
    
    public function __construct($path) {
        $this->strategy = self::$defaultStrategy;
        
        $path = is_link($path) ? readlink($path) : $path;
            
        if (is_dir($path)) {
            if (!is_file($path . "/" . self::LIST_NAME)) {
                throw new \Exception("Path provided resolved to a directory which doesn't contain a " . self::$listName . " file.");
            }
            $this->standalone = false;
        } else if (is_file($path)) {
            $this->standalone = true;
        } else {
            throw new \Exception("Path provided does not resolve to a directory or file.");
        }
        
        $this->path = $path;
    }

    public function pull() {
        if ($this->standalone) {
            $contents = file_get_contents($this->path);
        } else {
            $contents = file_get_contents($this->path . "/" . self::LIST_NAME);
        }
        
        // Using this option, if the file is not normalised (e.g.
        // contains blank lines/trailing spaces) the first push() will
        // definitely save the file, which could be useful.
        //$this->updateHash($contents);
        
        $list = new \TodoTxt\TodoList;
        $list->parseTasks($contents);
        
        // Using this option may use less traffic (less time spent
        // updating with a normalised list (original contents may
        // contain blank lines and such.
        $this->updateHash($list);
        
        return $list;
    }
    
    public function push(\TodoTxt\TodoList $list) {
        if ($this->compareHash($list) == 0) {
            // No changes to push
            return;
        }
        
        $contents = (string) $list;
        if ($this->standalone) {
            file_put_contents($this->path, $contents);
        } else {
            file_put_contents($this->path . "/" . self::LIST_NAME, $contents);
        }
    }
    
    protected function updateHash($contents) {
        $this->lastHash = md5((string) $contents);
    }
    
    protected function compareHash($comparison) {
        return strcmp(md5((string) $comparison), $this->lastHash);
    }
    
    public function setStrategy($strategy) {
        $strategies = array(self::STRATEGY_NORMALISE, self::STRATEGY_CONSERVATIVE);
        if (in_array($strategies, $strategy)) {
            $this->strategy = $strategy;
        }
    }
    
    public function getStrategy() {
        switch ($this->strategy) {
            case self::STRATEGY_NORMALISE: return "normalised";
            case self::STRATEGY_CONSERVATIVE: return "conservative";
            default: return sprintf("unknown (%d)", $this->strategy);
        }
    }
}