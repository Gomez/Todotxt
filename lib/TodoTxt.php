<?php

namespace OCA_TodoTxt;

class Storage {

    public static function getTodoTxts() {
        $TodoTxts=array();
        $list=\OC_FileCache::search('todo.txt');
        foreach($list as $l) {
            $info=pathinfo($l);
            $size=\OC_Filesystem::filesize($l);
            $mtime=\OC_Filesystem::filemtime($l);

            $entry=array('url'=>$l,'name'=>$info['filename'],'size'=>$size,'mtime'=>$mtime);
            $TodoTxts[]=$entry;
        }
        return $TodoTxts;
    }
}
