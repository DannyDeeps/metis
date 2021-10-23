<?php

namespace Metis\Events;

use \Metis\ORM\EntityCollection;
use \Metis\ORM\Models\Events\{
    IntervalEvent, TimedEvent, StaticEvent, ScheduledEvent
};
use \Metis\Framework\ViewHandler;

class Controller
{
    const CANVAS_TPL= "canvases/event";

    public static function getUserEvents(int $user_id)
    {
        $allEvents= [];

        $eventClasses= array_map(function($eventClass) use ($user_id) {
            $events= $eventClass::findAllByUserId($user_id);
            if (!empty($events)) {
                $allEvents[]= $events;
            }

            return $eventClass;
        }, [ new IntervalEvent, new TimedEvent, new StaticEvent, new ScheduledEvent ]);

        if (!empty($allEvents)) {
            return new EntityCollection($allEvents);
        }

        return [];
    }

    public static function getAllFormFields()
    {
        $allFormFields= [];

        foreach ([
            new StaticEvent,
            new TimedEvent,
            new IntervalEvent,
            new ScheduledEvent
        ] as $eventClass) {
            $formFields= $eventClass::getFormFields();
            $className= (new \ReflectionClass($eventClass))->getShortName();
            $allFormFields[$className]= $formFields;
        }

        return $allFormFields;
    }

    public static function createStaticEvent(
        string $name,
        string $description,
        int $eventTime
    ) {
        return (new StaticEvent)
            ->setName($name)
            ->setDescription($description)
            ->setEventTime($eventTime)
            ->save();
    }

    public static function createTimedEvent(
        string $name,
        string $description,
        string $interval
    ) {
        return (new TimedEvent)
            ->setName($name)
            ->setDescription($description)
            ->setInterval($interval)
            ->save();
    }

    public static function createIntervalEvent(
        string $name,
        string $description,
        int $intervalModifier,
        int $nextInterval
    ) {
        return (new IntervalEvent)
            ->setName($name)
            ->setDescription($description)
            ->setIntervalModifier($intervalModifier)
            ->setNextInterval($nextInterval)
            ->save();
    }

    public static function createScheduledEvent(
        string $name,
        string $description,
        string $mode,
        string $monthModifier,
        string $dayModifier,
        string $timeModifier
    ) {
        return (new ScheduledEvent)
            ->setName($name)
            ->setDescription($description)
            ->setMode($mode)
            ->setMonthModifier($monthModifier)
            ->setDayModifier($dayModifier)
            ->setTimeModifier($timeModifier)
            ->save();
    }

    public static function canvas()
    {
        global $VIEW_ENGINE;

        return (new ViewHandler($VIEW_ENGINE))->fetchView(self::CANVAS_TPL);
    }
}