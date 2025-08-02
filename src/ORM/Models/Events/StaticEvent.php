<?php

namespace Metis\ORM\Models\Events;

class StaticEvent extends \Metis\ORM\Entity
{
// STATICS
    /** @var string $_dbClass Database Class */
    protected static $_dbClass= '\Metis\Database\Metis';

    /** @var string $_dbTable Database Table */
    protected static $_dbTable= 'events_static';
}