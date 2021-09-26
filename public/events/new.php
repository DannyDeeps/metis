<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect, Request };
use Metis\Framework\{ Webpage, ActionHandler };
use Metis\Events\Controller;

if (!Login::userInSession()) {
    Redirect::to('login');
}

(new ActionHandler)->registerAction('createStaticEvent',
    function () {
        $REQ= Request::getAll();

        Controller::createStaticEvent(
            $REQ['name'],
            $REQ['description'],
            intval(date('YmdHis', strtotime($REQ['event_time'])))
        );
    }
)->registerAction('createTimedEvent',
    function () {
        $REQ= Request::getAll();

        Controller::createTimedEvent(
            $REQ['name'],
            $REQ['description'],
            $REQ['time_modifier']
        );
    }
)->registerAction('createScheduledEvent',
    function () {
        $REQ= Request::getAll();

        Controller::createScheduledEvent(
            $REQ['name'],
            $REQ['description'],
            $REQ['mode'],
            $REQ['month_modifier'],
            $REQ['day_modifier'],
            intval(date('Hi', strtotime($REQ['time_modifier'])))
        );
    }
)->registerAction('createIntervalEvent',
    function () {
        $REQ= Request::getAll();

        Controller::createIntervalEvent(
            $REQ['name'],
            $REQ['description'],
            $REQ['every'],
            $REQ['start_at']
        );
    }
)->triggerAction();

(new Webpage($viewEngine, 'pages::events/new', [
    'title' => 'New Event',
    'allFormFields' => Controller::getAllFormFields()
]))->renderPage();