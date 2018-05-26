<?php

namespace App\Http\Models;


class Users extends Generic
{
    public function __construct()
    {
        parent::__construct('users', 'idUser');
    }

    //
    // methods
    //

    public function insert($email, $username, $password)
    {
        $timeCreatedAt = time();

        $insertData = [
            'email' => $email,
            'username' => $username,
            'password' => md5($password),
            'createdAt' => $timeCreatedAt,
            'updatedAt' => $timeCreatedAt,
            'avatarImagePath' => 'https://api.adorable.io/avatars/285/'.$email,
            'isBanned' => 0,
        ];
        return parent::insertGetId($insertData);
    }
}