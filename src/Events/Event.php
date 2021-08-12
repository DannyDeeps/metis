<?php namespace Metis\Events;

    class Event extends \Metis\ORM\Entity
    {
    // STATICS
        /** @var string $dbClass Database Class */
        public static $_dbClass= '\Metis\Database\Metis';

        /** @var string $dbTable Database Table */
        public static $_dbTable= 'events';
    }