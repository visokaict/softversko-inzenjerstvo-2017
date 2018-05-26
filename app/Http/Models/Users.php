<?php

namespace App\Http\Models;

class Users extends Generic
{
    public $username, $email, $password;

    public function __construct()
    {
        parent::__construct('users', 'idUser');
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
}