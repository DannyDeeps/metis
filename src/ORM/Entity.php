<?php

namespace Metis\ORM;

use \Metis\System\Util;

abstract class Entity
{
    private $database;

    private $columns;

    public function __construct()
    {
        if (empty(static::$_dbClass)) {
            throw new \Exception("Database class not defined");
        }

        if (empty(static::$_dbTable)) {
            throw new \Exception("Database table not defined");
        }

        $this->_initDatabase();
        $this->_mapTable();
        $this->_initProperties();
    }

    private function _initDatabase()
    {
        if (empty($this->database)) {
            $this->database= $this->database ?? new static::$_dbClass;
        }
    }

    private function _mapTable()
    {
        if (empty($this->columns)) {
            $rawColumns= $this->database->describeTable(static::$_dbTable);

            $columns= [];
            foreach ($rawColumns as $rawColumn) {
                $columns[$rawColumn['COLUMN_NAME']]= new MysqlColumn($rawColumn);
            }

            $this->columns= $columns;
        }
    }

    private function _initProperties()
    {
        if (empty($this->columns)) {
            foreach ($this->columns as $column) {
                $propName= $column->name;

                if (!property_exists($this, $propName)) {
                    $default=
                        $column->default ??
                            (($column->nullable === 'YES') ? null : '');

                    $this->$propName= $default;
                }
            }
        }
    }

    private function _morph(array $properties)
    {
        $entityClass= get_called_class();

        $entity= new $entityClass;

        foreach ($this->columns as $column) {
            $propName= $column->name;

            if (array_key_exists($propName, $properties)) {
                $entity->_set($propName, $properties[$propName]);
            }
        }

        return $entity;
    }

    private function _antiMorph()
    {
        $properties= [];

        foreach ($this->columns as $column)
        {
            $propName= $column->name;

            if (!empty($this->$propName)) {
                $properties[$propName]= $this->$propName;
            }
        }

        return $properties;
    }

    private function getPrimaryKey()
    {
        foreach ($this->columns as $column) {
            if ($column->indexType === 'PRI') {
                return $column->name;
            }
        }

        return null;
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
            case 'findWhere': return $this->_findWhere($args[0]); break;
            case 'findAll': return $this->_findAll(); break;
            case 'findAllBy': return $this->_findAllBy($propName, $args[0]); break;
            case 'findAllWhere': return $this->_findAllWhere($args[0]); break;
        }
    }

    private function _get(string $propName)
    {
        return $this->$propName;
    }

    private function _set(string $propName, mixed $value)
    {
        $this->$propName= Util::sanitise($value);
        return $this;
    }

    private function _findBy(string $propName, mixed $value)
    {
        $fetch= $this->database->select(static::$_dbTable, [], [ $propName => $value ]);

        if (empty($fetch)) {
            return;
        }

        if (count($fetch) > 1) {
            throw new \Exception('Expected one but found many records using findBy*');
        }

        return $this->_morph($fetch[0]);
    }

    private function _findAllBy(string $propName, mixed $value)
    {
        $fetches= $this->database->select(static::$_dbTable, [], [ $propName => $value ]);

        if (empty($fetches)) {
            return null;
        }

        $entities= [];

        foreach ($fetches as $fetch) {
            $entities[]= $this->_morph($fetch);
        }

        return new EntityCollection($entities);
    }

    private function _findAll()
    {
        return $this->_findAllWhere([]);
    }

    private function _findWhere(array $filters)
    {
        $fetch= $this->database->select(static::$_dbTable, [], $filters);

        if (empty($fetch)) {
            return null;
        }

        if (count($fetch) > 1) {
            throw new \Exception('Expected one but found many records using findWhere');
        }

        return $this->_morph($fetch);
    }

    private function _findAllWhere(array $filters)
    {
        $fetches= $this->database->select(static::$_dbTable, [], $filters);

        if (empty($fetches)) {
            return null;
        }

        $entities= [];

        foreach ($fetches as $fetch) {
            $entities[]= $this->_morph($fetch);
        }

        return new EntityCollection($entities);
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
            case 'findWhere': return $entity->_findWhere($args[0]); break;
            case 'findAll': return $entity->_findAll(); break;
            case 'findAllBy': return $entity->_findAllBy($propName, $args[0]); break;
            case 'findAllWhere': return $entity->_findAllWhere($args[0]); break;
        }
    }

    private static function _getMethodType(string $methodName, bool $static= false)
    {
        $excMessage= $static ? "Static method not recognized" : "Method not recognized";

        $mode= match (true)
        {
            str_starts_with($methodName, 'get') => 'get',
            str_starts_with($methodName, 'set') => 'set',
            str_starts_with($methodName, 'findWhere') => 'findWhere',
            str_starts_with($methodName, 'findBy') => 'findBy',
            str_starts_with($methodName, 'findAll') => 'findAll',
            str_starts_with($methodName, 'findAllBy') => 'findAllBy',
            str_starts_with($methodName, 'findAllWhere') => 'findAllBy',

            default =>
                throw new \Exception($excMessage)
        };

        return $mode;
    }

    public static function getFormFields(bool $withSets= false)
    {
        $class= get_called_class();
        $entity= new $class;

        $formFields= [];
        foreach ($entity->columns as $field => $attributes) {
            if ($attributes->indexType === 'PRI' ||
                $attributes->type === 'timestamp'
            ) { continue; }

            // if ($attributes->indexType === 'MUL' && $withSets) {
            //     $parent= ucwords(explode('_', $field)[0]) . 's';
            //     $class= str_replace(' ', '', Util::snakeToDisplay(str_replace('_id', '', $field)));
            //     $relationClass= "\\Metis\\ORM\\Models\\{$parent}\\{$class}";

            //     $listSet= $relationClass::getListSet($relationClass);

            //     $formFields[$field]['sets'][strtolower($class)]= $listSet;
            // }

            $formFields[$field]['display']= Util::snakeToDisplay(str_replace('_id', '', $field));
            $formFields[$field]['required']= $attributes->nullable === 'YES' ? !0 : !1;
            $formFields[$field]['maxLength']= $attributes->maxLength;
            $formFields[$field]['type']= match($attributes->type) {
                'varchar'                                       => 'text',
                'text'                                          => 'textarea',
                'tinyint'                                       => 'checkbox',
                'smallint'                                      => 'time',
                'int' && str_contains($field, 'date')           => 'date',
                'int'                                           => 'number',
                'bigint'                                        => 'datetime-local',
                'set'                                           => 'select',

                default => null
            };

            if (!empty($attributes->setList)) {
                $formFields[$field]['setList']= $attributes->setList;
            }
        }

        return $formFields;
    }

    public static function getListSet(string $relationClass)
    {
        if (empty(static::$_setOptions)) {
            throw new \Exception("List set options not defined");
        }

        $entities= $relationClass::findAll();

        $listSet= [];
        foreach ($entities as $entity) {
            foreach (static::$_setOptions as $keyFunc => $valFunc) {
                $keyFunc= "get{$keyFunc}";
                $valFunc= "get{$valFunc}";

                $listSet[$entity->$keyFunc()]= $entity->$valFunc();
            }
        }

        // die('<pre>' . print_r($listSet, true) . '</pre>'); // kill

        return $listSet;
    }

    public function save()
    {
        $primaryKey= $this->getPrimaryKey();

        if (!empty($this->$primaryKey)) {
            $this->database->update(static::$_dbTable, $this->_antiMorph(), [ $primaryKey => $this->$primaryKey ]);
        } else {
            $autoIncrement= $this->database->insert(static::$_dbTable, $this->_antiMorph());
            $this->$primaryKey= $autoIncrement;
        }

        return $this;
    }
}