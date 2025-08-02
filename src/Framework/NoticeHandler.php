<?php namespace Metis\Framework;

use Metis\System\Session;

class NoticeHandler extends \Exception
{
    /** @var string $icon Fontawesome Icon Element */
    protected $icon= null;

    /** @var string $status Bootstrap Color Class */
    protected $status= null;

    public function __construct(\Exception $previous, string $status= 'info')
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);

        $this->icon= '<i class="fas fa-bug"></i>';
        $this->status= $status;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function save()
    {
        Session::addNotice($this);
    }
}