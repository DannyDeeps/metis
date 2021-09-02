<?php

namespace Metis\System;

class Request
{
    public static function get(string $varName)
    {
        return Util::sanitise($_REQUEST[$varName] ?? null);
    }

    public static function getAll()
    {
        $request= [];

        foreach ($_REQUEST as $name => $value) {
            $request[$name]= Util::sanitise($value);
        }

        return $request;
    }
}
