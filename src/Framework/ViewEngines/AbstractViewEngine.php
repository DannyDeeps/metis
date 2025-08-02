<?php

namespace Metis\Framework\ViewEngines;

abstract class AbstractViewEngine
{
    abstract function renderView(string $view);
    abstract function fetchView(string $view);
    abstract function addViewData(array $viewData);
    abstract protected function _commitViewData();
}
