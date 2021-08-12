<?php namespace Metis\Framework;

use \Metis\System\Session;
use \Metis\Users\User;

class Webpage
{
    private $viewEngine= null;
    private $template= null;
    private $templateData= [];

    const DEF_TEMPLATE_DATA= [
        'title' => 'Metis',
        'css' => [
            'vendor/bootstrap5.css'
        ],
        'js' => [
            'vendor/bootstrap5.js',
            'vendor/fontawesome5.js'
        ]
    ];

    public function __construct(\League\Plates\Engine $viewEngine, string $template, array $templateData)
    {
        $this->viewEngine= $viewEngine;
        $this->template= $template;
        $this->templateData= $templateData;
        $this->templateData= array_merge($this->templateData, self::DEF_TEMPLATE_DATA);

        return $this;
    }

    public function requireJs(string $file)
    {
        $this->templateData['js'][]= $file;

        return $this;
    }

    public function assignData(array $dataToAssign)
    {
        $this->templateData= array_merge($this->templateData, $dataToAssign);
        return $this;
    }

    public function renderPage(array $templateData= null)
    {
        if (!empty($templateData))
            $this->templateData= array_merge($this->templateData, $templateData);

        $this->_loadNotices();
        $this->_loadUser();
        $this->viewEngine->addData($this->templateData);
        echo $this->viewEngine->render($this->template);
        exit;
    }

    private function _loadNotices()
    {
        $notices= Session::getNotices();

        $this->assignData([ 'notices' => $notices ]);
        $this->requireJs('toasts-init.js');

        Session::clearNotices();
    }

    private function _loadUser()
    {
        $this->assignData(['user' => User::findById(Session::get('user_id'))]);
    }
}