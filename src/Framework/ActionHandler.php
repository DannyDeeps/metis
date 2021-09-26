<?php

namespace Metis\Framework;

use Metis\System\Request;

class ActionHandler
{
    private $actions= [];

    private $action= null;

    public function __construct() {
        if (!empty(Request::get('action'))) {
            $this->action= Request::get('action');
        }

        return $this;
    }

    public function registerAction(string $action, callable|string $method)
    {
        $this->actions[$action]= $method;

        return $this;
    }

    public function triggerAction()
    {
        if (!empty($this->action)) {
            if (empty($this->actions[$this->action])) {
                throw new \Exception("Action not registered: {$this->action}");
            }

            if (is_callable($this->actions[$this->action])) {
                $this->actions[$this->action]();
            }
        }

        return $this;
    }
}