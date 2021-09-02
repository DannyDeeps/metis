<?php

namespace Metis\ORM\Models\Events;

class EventType extends \Metis\ORM\Entity
{
// STATICS
    /** @var string $_dbClass Database Class */
    protected static $_dbClass= '\Metis\Database\Metis';

    /** @var string $_dbTable Database Table */
    protected static $_dbTable= 'event_types';

    /** @var string $_setOptions Key and Value used when retrieveing List Set */
    protected static $_setOptions= [ 'Id' => 'Name' ];
}