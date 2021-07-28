<?php namespace Metis\Events;

    /**
     * undocumented class
     */
    class Type extends \Metis\ORM\Entity
    {
    // STATICS
        /** @var string $dbClass Database Class */
        public static $dbClass= "\\Metis\\Database\\Metis";

        /** @var string $dbTable Database Table */
        public static $dbTable= 'event_types';

    // VARS
        /** @var int $id Event Type ID */
        private $id= null;
        public function getId() { return $this->id; }
        public function setId($id) { $this->id= $id; return $this; }

        /** @var string $name Event Type Name */
        private $name= null;
        public function getName() { return $this->name; }
        public function setName($name) { $this->name= $name; return $this; }
    }