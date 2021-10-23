<?php

use Metis\Framework\ViewEngines\SmartyEngine;

$smarty= new Smarty;

$smarty->setTemplateDir( VIEWS_ROOT );
$smarty->setCompileDir( VIEWS_ROOT . 'compiled' );
$smarty->setConfigDir( './smarty-config' );
$smarty->setCacheDir( CACHE_ROOT . 'smarty' );

$smarty->setForceCompile(true);
// $smarty->debugging= true;

$VIEW_ENGINE= new SmartyEngine($smarty, [
    'pageLinks' => [[
        'title' => 'Dashboard',
        'location' => '/dashboard',
        'icon' => 'fa-columns'
    ],[
        'title' => 'Events',
        'location' => '/events',
        'icon' => 'fa-calendar-alt'
    ]]
]);