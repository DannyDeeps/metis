<?php
    $viewEngine= new League\Plates\Engine();
    $viewEngine->setFileExtension('phtml');
    $viewEngine->addFolder('shared', VIEWS . 'shared');
    $viewEngine->addFolder('layouts', VIEWS . 'layouts');
    $viewEngine->addFolder('pages', VIEWS . 'pages');