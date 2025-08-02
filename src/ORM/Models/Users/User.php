<?php

namespace Metis\ORM\Models\Users;

class User extends \Metis\ORM\Entity
{
// STATICS
    /** @var string $dbClass Database Class */
    protected static $_dbClass= '\Metis\Database\Metis';

    /** @var string $dbTable Database Table */
    protected static $_dbTable= 'users';

    /** @var string $_setOptions Key and Value used when retrieveing List Set */
    protected static $_setOptions= [ 'Id' => 'Username' ];
}