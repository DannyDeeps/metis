<?php namespace Metis\ORM;

    use \Metis\Exceptions\NoticeException;
    use \Metis\System\Util;

    abstract class Entity
    {
        private $database;

        private $columns;

        public function __construct()
        { // die('constructing.. ');

            if (empty(static::$_dbClass))
            {
                NoticeException::create("Database class not defined");
            }

            if (empty(static::$_dbTable))
            {
                NoticeException::create("Database table not defined");
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

        public function __call(string $method, mixed $args)
        {
            $mode= str_starts_with($method, 'get') ? 'get' : null;
            $mode= str_starts_with($method, 'set') ? 'set' : null;
            $mode= str_starts_with($method, 'findBy') ? 'findBy' : null;

            if (empty($mode))
            {
                NoticeException::create("Method not recognized");
            }

            $propName= Util::pascalToSnake(preg_replace("/^$mode/", '', $method));

            switch ($mode)
            {
                case 'get':    return $this->_get($propName); break;
                case 'set':    return $this->_set($propName, $args[0]); break;
                case 'findBy': return $this->_findBy($propName, $args[0]); break;
            }
        }

        public static function __callStatic(string $method, mixed $args)
        {
            $mode= str_starts_with($method, 'findBy') ? 'findBy' : null;

            if (empty($mode))
            {
                NoticeException::create("Static method not recognized");
            }

            $propName= Util::pascalToSnake(preg_replace("/^$mode/", '', $method));

            $class= get_called_class();
            $entity= new $class;

            switch ($mode)
            {
                case 'findBy': return $entity->_findBy($propName, $args[0]); break;
            }
        }

        private function _get(string $propName)
        {
            return $this->$propName;
        }

        private function _set(string $propName, mixed $value)
        {
            // TODO: validation

            $this->$propName= $value;
            return $this;
        }

        private function _findBy(string $propName, mixed $value)
        {
            $fetch= $this->database->select(static::$_dbTable, [], [ $propName => $value ]);

            return $this->morph($fetch[0]);
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