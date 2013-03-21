<?php
/**
* ownCloud - TodoTxt for ownCloud
*
* @author Steffen Lindner
* @copyright 2013 Steffen Lidnner <gomez@flexiabel.de>
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library. If not, see <http://www.gnu.org/licenses/>.
*
*/

namespace OCA_TodoTxt;

class Storage {

    public static function getTodoTxts() {
        $TodoTxts=array();
        $files = array();
        $folder=\OC\Files\Filesystem::search('todo');
        $todofiles=\OC\Files\Filesystem::search('todo.txt');
        foreach($todofiles as $file) {
            if (strrpos($folder[0], $file) === false) {
                $info=pathinfo($file);
                $size=\OC\Files\Filesystem::filesize($file);
                $mtime=\OC\Files\Filesystem::filemtime($file);

                $entry=array('url'=>$file,'name'=>$info['filename'],'size'=>$size,'mtime'=>$mtime);
                $TodoTxts[]=$entry;
            }
        }
        return $TodoTxts;
    }
}
