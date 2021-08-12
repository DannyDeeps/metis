<?php namespace Metis\Events;

    class Type extends \Metis\ORM\Entity
    {
    // STATICS
        /** @var string $dbClass Database Class */
        protected static $_dbClass= '\Metis\Database\Metis';

        /** @var string $dbTable Database Table */
        protected static $_dbTable= 'event_types';
    }