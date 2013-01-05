<?php

/**
* ownCloud - TodoTxt for ownCloud
*
* @author Steffen Lindner
* @copyright 2013 Steffen Lindner gomez@flexiabel.de
* 3rdparty
* @copyright 2012 Gentleface.com todo.png CC License
* 
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either 
* version 3 of the License, or any later version.
* 
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*  
* You should have received a copy of the GNU Lesser General Public 
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
* 
*/

/*
Changelog:

0.1 initial release

*/

$l = new OC_L10N('Todotxt');

OCP\App::addNavigationEntry( array(
    'id' => 'Todotxt_index',
    'order' => 11,
    'href' => OCP\Util::linkTo( 'Todotxt', 'index.php' ),
    'icon' => OCP\Util::imagePath( 'Todotxt', 'todotxt.png' ),
    'name' => $l->t('Todotxt')
    )
);


