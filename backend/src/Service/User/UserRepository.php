<?php


namespace App\Service\User;


use App\Model\UserQuery;

class UserRepository
{
    public function getUserByEmail($email)
    {
        return UserQuery::create()->findOneByEmail($email);
    }
}
