<?php namespace Metis\Events;

    /**
     * undocumented class
     */
    class Event extends \Metis\ORM\Entity
    {
    // STATICS
        /** @var string $dbClass Database Class */
        public static $dbClass= "\\Metis\\Database\\Metis";

        /** @var string $dbTable Database Table */
        public static $dbTable= 'events';

    // VARS
        /** @var int $id Event ID */
        private $id= null;
        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; return $this; }

        /** @var int $user_id User ID */
        private $user_id= null;
        public function getUserId() { return $this->user_id; }
        public function setUserId($user_id) { $this->user_id = $user_id; return $this; }

        /** @var int $event_type Event Type ID */
        private $event_type= null;
        public function getEventType() { return $this->event_type; }
        public function setEventType($event_type) { $this->event_type = $event_type; return $this; }

        /** @var string $content Event Content */
        private $content= null;
        public function getContent() { return $this->content; }
        public function setContent($content) { $this->content = $content; return $this; }


    }