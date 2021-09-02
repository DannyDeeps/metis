<?php

namespace Metis\System;

class Util
{
    public static function pascalToSnake($input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }

    public static function snakeToDisplay($input)
    {
        return ucwords(str_replace('_', ' ', strtolower($input)));
    }

    public static function sanitise(mixed $input)
    {
        $filter= self::findFilter($input);

        return filter_var($input, $filter);
    }

    public static function findFilter(mixed $var)
    {
        $type= self::getVarType($var);
        $filter= match($type) {
            'string' => FILTER_SANITIZE_STRING,

            default => FILTER_DEFAULT

            // 'boolean',
            // 'integer',
            // 'double',
            // 'object',
            // 'resource',
            // 'resource (closed)',
            // 'array',
            // 'NULL',
            // 'unknown type',
        };

        return $filter;
    }

    public static function getVarType(mixed $var)
    {
        return gettype($var);
    }
}
