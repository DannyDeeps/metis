<?php

namespace Metis\Framework;

use \Metis\System\Session;
use \Metis\ORM\Models\Users\User;
use \Metis\Framework\ViewEngines\AbstractViewEngine;

class ViewHandler
{
    const DEF_VIEW_DATA= [
        'title' => 'Metis',
        'css' => [
            'dark',
            // 'vendor/bootstrap5'
            'vendor/semantic.min'
        ],
        'js' => [
            'vendor/jquery3',
            'vendor/semantic.min',
            // 'vendor/bootstrap5',
            'vendor/fontawesome5'
        ]
    ];

    public function __construct(
        private AbstractViewEngine $viewEngine,
        private array $viewData= [],
        private string $view= ''
    ) {
        $this->viewData= array_merge(self::DEF_VIEW_DATA, $this->viewData);

        return $this;
    }

    public function requireJs(string $file)
    {
        $this->viewData['js'][]= $file;

        return $this;
    }

    public function addViewData(array $viewData)
    {
        $this->viewData= array_merge($this->viewData, $viewData);

        return $this;
    }

    public function renderView(string $view)
    {
        $this->_loadNotices();
        $this->_loadUser();

        $this->viewEngine->addViewData($this->viewData);

        echo $this->viewEngine->renderView($view);
        exit;
    }

    public function fetchView(string $view)
    {
        $this->_loadNotices();
        $this->_loadUser();

        $this->viewEngine->addViewData($this->viewData);

        return $this->viewEngine->fetchView($view);
    }

    private function _loadNotices()
    {
        $this->addViewData([
            'notices' => Session::getNotices()
        ]);

        $this->requireJs('toasts/init');

        Session::clearNotices();
    }

    private function _loadUser()
    {
        $this->addViewData([
            'user' => User::findById(Session::get('user_id'))
        ]);
    }
}