<?php

namespace Metis\ORM;

use \Metis\System\Util;

abstract class Entity
{
    private $database;

    private $columns;

    public function __construct()
    { // die('constructing.. ');

        if (empty(static::$_dbClass))
        {
            throw new \Exception("Database class not defined");
        }

        if (empty(static::$_dbTable))
        {
            throw new \Exception("Database table not defined");
        }

        $this->_initDatabase();
        $this->_mapTable();
        $this->_initProperties();
    }

    private function _initDatabase()
    {
        if (empty($this->database))
        {
            $this->database= $this->database ?? new static::$_dbClass;
        }
    }

    private function _mapTable()
    {
        if (empty($this->columns))
        {
            $rawColumns= $this->database->describeTable(static::$_dbTable);

            $columns= [];
            foreach ($rawColumns as $rawColumn)
            {
                $columns[$rawColumn['COLUMN_NAME']]= new MysqlColumn($rawColumn);
            }

            $this->columns= $columns;
        }
    }

    private function _initProperties()
    {
        foreach ($this->columns as $column)
        {
            $propName= $column->name;

            if (!property_exists($this, $propName))
            {
                $default=
                    $column->default ??
                        (($column->nullable === 'YES') ? null : '');

                $this->$propName= $default;
            }
        }
    }

    public function __call(string $methodName, mixed $args)
    {
        $methodType= self::_getMethodType($methodName);

        $propName= Util::pascalToSnake(preg_replace("/^$methodType/", '', $methodName));

        switch ($methodType)
        {
            case 'get':    return $this->_get($propName); break;
            case 'set':    return $this->_set($propName, $args[0]); break;
            case 'findBy': return $this->_findBy($propName, $args[0]); break;
            case 'findAllBy': return $this->_findAllBy($propName, $args[0]); break;
        }
    }

    public static function __callStatic(string $methodName, mixed $args)
    {
        $methodType= self::_getMethodType($methodName, true);

        $propName= Util::pascalToSnake(preg_replace("/^$methodType/", '', $methodName));

        $class= get_called_class();
        $entity= new $class;

        switch ($methodType)
        {
            case 'findBy': return $entity->_findBy($propName, $args[0]); break;
            case 'findAllBy': return $entity->_findAllBy($propName, $args[0]); break;
            case 'findWhere': return $entity->findWhere($args[0]); break;
            case 'findAllWhere': return $entity->findAllWhere($args[0]); break;
        }
    }

    private static function _getMethodType(string $methodName, bool $static= false)
    {
        $excMessage= $static ? "Static method not recognized" : "Method not recognized";

        $mode= match (true)
        {
            str_starts_with($methodName, 'get') => 'get',
            str_starts_with($methodName, 'set') => 'set',
            str_starts_with($methodName, 'findBy') => 'findBy',
            str_starts_with($methodName, 'findAllBy') => 'findAllBy',

            default =>
                throw new \Exception($excMessage)
        };

        return $mode;
    }

    public function _get(string $propName)
    {
        return $this->$propName;
    }

    public function _set(string $propName, mixed $value)
    {
        // TODO: validation

        $this->$propName= $value;
        return $this;
    }

    private function _findBy(string $propName, mixed $value)
    {
        $fetch= $this->database->select(static::$_dbTable, [], [ $propName => $value ]);

        if (empty($fetch))
        {
            return null;
        }

        if (count($fetch) > 1)
        {
            throw new \Exception('Expected one but found many records using findBy*');
        }

        return $this->morph($fetch[0]);
    }

    private function _findAllBy(string $propName, mixed $value)
    {
        $fetches= $this->database->select(static::$_dbTable, [], [ $propName => $value ]);

        if (empty($fetches))
        {
            return null;
        }

        $entities= [];

        foreach ($fetches as $fetch)
        {
            $entities[]= $this->morph($fetch);
        }

        return new EntityCollection($entities);
    }

    public function findWhere(array $filters)
    {
        $fetch= $this->database->select(static::$_dbTable, [], $filters);

        if (empty($fetch))
        {
            return null;
        }

        if (count($fetch) > 1)
        {
            throw new \Exception('Expected one but found many records using findWhere');
        }

        return $this->morph($fetch);
    }

    public function findAllWhere(array $filters)
    {
        $fetches= $this->database->select(static::$_dbTable, [], $filters);

        if (empty($fetches))
        {
            return null;
        }

        $entities= [];

        foreach ($fetches as $fetch)
        {
            $entities[]= $this->morph($fetch);
        }

        return new EntityCollection($entities);
    }

    private function morph(array $properties)
    {
        $entityClass= get_called_class();

        $entity= new $entityClass;

        foreach ($this->columns as $column)
        {
            $propName= $column->name;

            if (array_key_exists($propName, $properties))
            {
                $entity->_set($propName, $properties[$propName]);
            }
        }

        return $entity;
    }
}