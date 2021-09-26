<?php
    use Metis\System\Util;

    $viewEngine= new League\Plates\Engine();
    $viewEngine->setFileExtension('phtml');

    $viewEngine->addFolder('layouts', VIEWS . 'layouts');
    $viewEngine->addFolder('pages', VIEWS . 'pages');
    $viewEngine->addFolder('framework', VIEWS . 'framework');
    $viewEngine->addFolder('tiles', VIEWS . 'tiles');
    $viewEngine->addFolder('toasts', VIEWS . 'toasts');
    $viewEngine->addFolder('forms', VIEWS . 'forms');

    $viewEngine->registerFunction('pascaltodisplay', function ($input) {
        return Util::pascalToDisplay($input);
    });