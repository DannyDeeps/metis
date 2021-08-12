<?php namespace Metis\Users;

/**
 * TODO:
 *  Sanitisation & Validation on certain fields
 */

class User extends \Metis\ORM\Entity
{
// STATICS
    /** @var string $dbClass Database Class */
    protected static $_dbClass= '\Metis\Database\Metis';

    /** @var string $dbTable Database Table */
    protected static $_dbTable= 'users';
}