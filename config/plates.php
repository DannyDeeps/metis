<?php

use Metis\System\Util;

$VIEW_ENGINE= new League\Plates\Engine();
$VIEW_ENGINE->setFileExtension('phtml');

$VIEW_ENGINE->addFolder('layouts', VIEWS . 'layouts');
$VIEW_ENGINE->addFolder('pages', VIEWS . 'pages');
$VIEW_ENGINE->addFolder('framework', VIEWS . 'framework');
$VIEW_ENGINE->addFolder('tiles', VIEWS . 'tiles');
$VIEW_ENGINE->addFolder('toasts', VIEWS . 'toasts');
$VIEW_ENGINE->addFolder('forms', VIEWS . 'forms');

$VIEW_ENGINE->registerFunction('pascaltodisplay', function ($input) {
    return Util::pascalToDisplay($input);
});