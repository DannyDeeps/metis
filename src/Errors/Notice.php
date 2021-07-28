<?php namespace Metis\Errors;

use Metis\System\Session;

class Notice extends \Exception
{
    /** @var string $icon Fontawesome Icon Element */
    protected $icon= null;

    /** @var string $status Bootstrap Color Class */
    protected $status= null;

    public function __construct(string $message, int $code= 0, \Exception $previous= null, string $status= 'info')
    {
        parent::__construct($message, $code, $previous);

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

    public static function create(string $message, int $code= 0, \Exception $previous= null, string $status= 'info')
    {
        Session::set('notice', new self($message, $code, $previous, $status)); return;
    }
}