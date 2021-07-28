<?php namespace Metis\ORM;

class Entity
{
    private static $database;

    /**
     * Init Database
     *
     * Checks for required static variables ($dbClass/$dbTable) that must be defined in extending class, instantiates the database class into a static variable for use with static and non-static functions
     */
    public static function initDatabaseClass()
    {
        if (empty(static::$dbClass))
            throw new \Exception("Missing database class");
        if (empty(static::$dbTable))
            throw new \Exception("Missing database table");

        if (empty(self::$database))
            self::$database= new static::$dbClass;
    }

    /**
     * Get
     *
     * Gets a record by its ID
     *
     * @param int $id Required. ID of the record.
     *
     * @return this $entity An entity of extending class.
     */
    public static function get(int $id= null)
    {
        self::initDatabaseClass();

        $fetch= self::$database->select(static::$dbTable, [], [ 'id' => $id ], 1);

        $entity= self::morph($fetch);

        return $entity;
    }

    /**
     * Find
     *
     * Find record by given filters
     *
     * @param array $filers Optional. Associative array of field and value to filter results by.
     *
     * @return array $entities An array of entities of the extending class.
     */
    public static function find(array $filters= [])
    {
        self::initDatabaseClass();

        $entities= [];

        $fetches= self::$database->select(static::$dbTable, [], $filters);
        foreach ($fetches as $fetch)
            $entities[]= self::morph($fetch);

        return $entities;
    }

    /**
     * Find One
     *
     * Find one record by given filters
     *
     * @param array $filers Optional. Associative array of field and value to filter results by.
     *
     * @return array $entities[0] An entity of the extending class.
     *
     * @throws Exception if more than one record found
     */
    public static function findOne(array $filters= [])
    {
        self::initDatabaseClass();

        $entities= self::find($filters);
        if (empty($entities))
            return null;

        if (count($entities) > 1)
            throw new \Exception("Found more than one record using findOne method");

        return $entities[0];
    }

    /**
     * Morph
     *
     * Transforms a database response into an entity of $this class
     *
     * @param array $fetch Required. Database row query result
     *
     * @return Entity $entity Returns instance of extending class
     */
    public static function morph(array $fetch)
    {
        $class= new \ReflectionClass(get_called_class());

        $entity= $class->newInstance();

        foreach ($class->getProperties(\ReflectionProperty::IS_PRIVATE) as $prop) {
            if (isset($fetch[$prop->getName()])) {
                $prop->setAccessible(true);
                $prop->setValue($entity, $fetch[$prop->getName()]);
            }
        }

        return $entity;
    }

    /**
     * Save
     *
     * Saves changes to database
     *
     * @throws Exception if database operation returns empty result
     **/
    public function save() {
        self::initDatabaseClass();

        $class= new \ReflectionClass($this);
        $hasId= (!empty($this->getId())) ? $this->getId() : false;

        $dbPacket= [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PRIVATE) as $property) {
            $propName= $property->getName();
            $property->setAccessible(true);
            $dbPacket[$propName]= $property->getValue($this);
        }

        if ($hasId)
            $result= self::$database->update(static::$dbTable, $dbPacket, [ 'id' => $hasId ]);
        else
            $result= self::$database->insert(static::$dbTable, $dbPacket);
        if (empty($result))
            throw new \Exception("Failed to insert or update database");

        $this->setId($result);

        return $this;
    }
}
