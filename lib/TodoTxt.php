<?php

namespace OCA_TodoTxt;

class Storage {

    public static function getTodoTxts() {
        $TodoTxts=array();
        $files = array();
        $folder=\OC_FileCache::search('todo');
        $todofiles=\OC_FileCache::search('todo.txt');
        //error_log(var_export($list, true));
        foreach($todofiles as $file) {
            if (strrpos($folder[0], $file) === false) {
                $info=pathinfo($file);
                $size=\OC_Filesystem::filesize($file);
                $mtime=\OC_Filesystem::filemtime($file);

                $entry=array('url'=>$file,'name'=>$info['filename'],'size'=>$size,'mtime'=>$mtime);
                $TodoTxts[]=$entry;
            }
        }
        return $TodoTxts;
    }
}
