<?php require_once '../../includes/start.php';

use Metis\System\{ Login, Redirect, Session, Request };
use Metis\Framework\Webpage;
use Metis\Errors\Notice;
use Metis\Exceptions\MetisException;
use Metis\ORM\Models\Users\User;
use Metis\ORM\Models\Events\{ Event, Type };

if (!Login::userInSession()) {
    Redirect::to('login');
}

if (isset($_REQUEST['createEvent'])) {
    try {
        $type= (!empty(Request::get('type_new'))) ? Request::get('type_new') : Request::get('type');

        $newEvent= new Event;
        $newEvent
            ->setUserId(Session::get('user_id'))
            ->setEventType($type)
            ->setDescription(Request::get('description'))
            ->save();

        Redirect::to('events');
    } catch (Exception $exc) {
        Session::addNotice(new MetisException($exc, 'danger'));
    }
}

(new Webpage($viewEngine, 'pages::events/new', [
    'title' => 'New Event',
    'formFields' => Event::getFormFields(true)
]))->renderPage();