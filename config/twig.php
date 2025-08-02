<?php

use Metis\System\Util;
use Metis\Framework\ViewEngines\TwigEngine;

$twigLoader= new Twig\Loader\FileSystemLoader(VIEWS_ROOT);

$twigLoader->addPath(VIEWS_ROOT . 'layouts', 'layouts');
$twigLoader->addPath(VIEWS_ROOT . 'pages', 'pages');
$twigLoader->addPath(VIEWS_ROOT . 'framework', 'framework');
$twigLoader->addPath(VIEWS_ROOT . 'tiles', 'tiles');
$twigLoader->addPath(VIEWS_ROOT . 'toasts', 'toasts');
$twigLoader->addPath(VIEWS_ROOT . 'forms', 'forms');
$twigLoader->addPath(VIEWS_ROOT . 'canvases', 'canvases');

$twig= new Twig\Environment($twigLoader, [
    // 'cache' => CACHE_ROOT . 'views-compiled/',
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$filters= [];
$filters[]= new Twig\TwigFilter('pascaltodisplay', function(string $string) {
    return Util::pascalToDisplay($string);
});
$filters[]= new Twig\TwigFilter('empty', function(mixed $var) {
    return empty($var);
});

foreach ($filters as $filter) {
    $twig->addFilter($filter);
}

$twig->addGlobal('pageLinks', [
    [ 'title' => 'Dashboard', 'location' => '/dashboard', 'icon' => 'fa-columns' ],
    [ 'title' => 'Events', 'location' => '/events', 'icon' => 'fa-calendar-alt' ]
]);

$VIEW_ENGINE= new TwigEngine($twig);