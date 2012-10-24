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
$errors = array();
$l = new OC_L10N('TODOtxt');
OCP\User::checkLoggedIn();

$required_apps = array(
    array('id' => 'tal', 'name' => 'TAL Page Templates'),
    array('id' => 'TODOtxt', 'name' => 'TODOtxt'),
);

foreach($required_apps as $app) {
    if(!OCP\App::isEnabled($app['id'])) {
        $error = (string)$l->t('The %%s app isn\'t enabled! Please enable it here: <strong><a href="%%s?appid=%%s">Enable %%s app</a></strong>');
        $errors[] = sprintf($error, $app['name'],OCP\Util::linkTo('settings', 'apps'), $app['id'], $app['name']);
    }
}

if($errors) {
    $tmpl = new OCP\Template( "TODOtxt", "rtfm", "user" );
    $tmpl->assign('errors',$errors, false);
} else {
    $tmpl = new OC_TALTemplate('TODOtxt', 'index', 'user');
    $tmpl->assign('id',$id);
}

$tmpl->printPage();
