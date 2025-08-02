<?php require_once __DIR__ . '/../../includes/start.php';

use Metis\System\{ Request as Req };
use Metis\Framework\{ ActionHandler, AjaxHelper as Ajax };
use Metis\Events\Controller as Event;

new AjaxEventHandler;
class AjaxEventHandler
{
    public function __construct()
    {
        (new ActionHandler)
            ->registerAction('canvas', function() {
                try {
                    Ajax::success('', [
                        'html' => Event::canvas()
                    ]);
                } catch (\Exception $exc) {
                    Ajax::fail($exc->getMessage());
                }
            })
            ->registerAction('createStatic', function() {
                try {
                    Event::createStaticEvent(
                        Req::get('name'),
                        Req::get('description'),
                        Req::get('eventTime')
                    );

                    Ajax::success();
                } catch (\Exception $exc) {
                    Ajax::fail($exc->getMessage());
                }
            })
            ->registerAction('createTimed', function() {
                try {
                    Event::createTimedEvent(
                        Req::get('name'),
                        Req::get('description'),
                        Req::get('interval')
                    );

                    Ajax::success();
                } catch (\Exception $exc) {
                    Ajax::fail($exc->getMessage());
                }
            })
            ->registerAction('createInterval', function() {
                try {
                    Event::createIntervalEvent(
                        Req::get('name'),
                        Req::get('description'),
                        Req::get('intervalModifier'),
                        Req::get('nextInterval')
                    );

                    Ajax::success();
                } catch (\Exception $exc) {
                    Ajax::fail($exc->getMessage());
                }
            })
            ->registerAction('createScheduled', function() {
                try {
                    Event::createScheduledEvent(
                        Req::get('name'),
                        Req::get('description'),
                        Req::get('mode'),
                        Req::get('monthModifier'),
                        Req::get('dayModifier'),
                        Req::get('timeModifier')
                    );

                    Ajax::success();
                } catch (\Exception $exc) {
                    Ajax::fail($exc->getMessage());
                }
            })->triggerAction();
    }
}