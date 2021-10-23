<?php

use Metis\System\Session;
use Metis\Users\User;

if (!empty(Session::get('user_id'))) {
    Session::set('user', User::findById(Session::get('user_id')));
}