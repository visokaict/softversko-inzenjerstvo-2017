<?php

namespace App\Http\Models;

class Users extends Generic
{
    public $username, $email, $password;

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

    public function getByUsernameAndPassword(){
        $result = \DB::table("users")
                    ->select('*')
                    //->select('users.*', 'roles.name')
                    //->join('roles','users.idRole', '=', 'roles.idRole')
					->where([
						'username' => $this->username,
						'password' => md5($this->password)
					])
					->first();
		return $result;
	}

	public function addRole($idRole, $idUser)
    {
        return \DB::table('users_roles')
            ->insert([
                'idUser' => $idUser,
                'idRole' => $idRole,
            ]);
    }

}