<?php

namespace Metis\Framework\ViewEngines;

class SmartyEngine extends AbstractViewEngine
{
    public function __construct(
        private \Smarty $smarty,
        private array $viewData= []
    ) {}

    public function addViewData(array $viewData)
    {
        foreach ($viewData as $key => $value) {
            $this->viewData[$key]= $value;
        }
    }

    public function renderView(string $view)
    {
        $this->_commitViewData();

        $this->smarty->display($view);
    }

    public function fetchView(string $view)
    {
        $this->_commitViewData();

        return $this->smarty->fetch($view);
    }

    protected function _commitViewData()
    {
        if (!empty($this->viewData)) {
            foreach ($this->viewData as $key => $value) {
                $this->smarty->assign($key, $value);
            }
        }
    }
}