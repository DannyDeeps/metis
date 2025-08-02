<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Session };
use Metis\Framework\ViewHandler;
use Metis\Events\Controller;
use Metis\ORM\Models\Users\User;

Login::required();

(new ViewHandler($VIEW_ENGINE, [
    'title' => 'Events',
    'user' => User::get(Session::get('user_id')),
    'eventTypes' => Controller::getUserEvents(Session::get('user_id'))
]))
    ->requireJs('canvases/event-canvas')
    ->renderView('pages/events/main.tpl');