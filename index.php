<?php
/**
* ownCloud - Journal
*
* @author Thomas Tanghus
* @copyright 2012 Thomas Tanghus <thomas@tanghus.net>
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

require_once 'lib/Todotxt.php';

//__autoloader dont work, manual require:
require_once '3rdparty/TodoTxt/Loader/LocalLoader.php';
require_once '3rdparty/TodoTxt/TodoList.php';
require_once '3rdparty/TodoTxt/Task.php';

OCP\Util::addStyle( 'Todotxt', 'style' );
OCP\Util::addscript( 'Todotxt', 'aceeditor/ace');
OCP\Util::addscript( 'Todotxt', 'editor');

$errors = array();
$l = new OC_L10N('Todotxt');
OCP\User::checkLoggedIn();
OCP\JSON::checkLoggedIn();

$required_apps = array(
    array('id' => 'tal', 'name' => 'TAL Page Templates'),
    array('id' => 'Todotxt', 'name' => 'Todotxt'),
);

foreach($required_apps as $app) {
    if(!OCP\App::isEnabled($app['id'])) {
        $error = (string)$l->t('The %%s app isn\'t enabled! Please enable it here: <strong><a href="%%s?appid=%%s">Enable %%s app</a></strong>');
        $errors[] = sprintf($error, $app['name'],OCP\Util::linkTo('settings', 'apps'), $app['id'], $app['name']);
    }
}

$todoTxtList=\OCA_Todotxt\Storage::getTodotxts();

$userhome = OC_User::getHome(OCP\User::getUser());

//Load 3rdparty todotxt
$loader = new TodoTxt\Loader\LocalLoader($userhome . "/files" . $todoTxtList[0]['url']); //standalone
$list = $loader->pull();
//usort($tasks, array("TodoTxt\TodoList", "cmpPI"));
$tasks = $list->sortByContexts(); 

//error_log(var_export($tasks, true));

if($errors) {
    $tmpl = new OCP\Template( "Todotxt", "rtfm", "user" );
    $tmpl->assign('errors',$errors, false);
} else {
    $tmpl = new OC_TALTemplate('Todotxt', 'index', 'user');
    $tmpl->assign('list',$tasks);
}

$tmpl->printPage();
