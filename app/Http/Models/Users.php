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
            'avatarImagePath' => 'https://api.adorable.io/avatars/285/' . $email,
            'isBanned' => 0,
        ];
        return parent::insertGetId($insertData);
    }

    public function updateUser($idUser, $updateData){
        $updateData['updatedAt'] = time();

        return parent::update($idUser, $updateData);
    }

    public function getByUsernameOrEmailAndPassword($usernameEmail, $password)
    {
        $result = \DB::table($this->tableName)
                    ->select('*')
                    ->where('password', '=', md5($password))
                    ->where(function ($query) use ($usernameEmail) {
                        $query->where('username', '=', strtolower($usernameEmail))
                            ->orWhere('email', '=', strtolower($usernameEmail));
                    })
					->first();
		return $result;
	}

	public function getByUsername($username)
    {
        return \DB::table($this->tableName)
            ->select('*')
            ->where('username', '=', $username)
            ->first();
    }

	public function addRole($idRole, $idUser)
    {
        return \DB::table('users_roles')
            ->insert([
                'idUser' => $idUser,
                'idRole' => $idRole,
            ]);
    }

    public function deleteRole($userId, $roleId){
        return \DB::table('users_roles')
            ->where("idUser", "=", $userId)
            ->where("idRole", "=", $roleId)
            ->delete();
    }

    public function getAllRoles($userId)
    {
        return \DB::table('users_roles')
            ->join('roles', 'users_roles.idRole', '=', 'roles.idRole')
            ->select('*')
            ->where('users_roles.idUser', '=', $userId)
            ->get();
    }

    public function getByAccessToken($token)
    {
        return \DB::table($this->tableName)
            ->select('*')
            ->where('accessToken', '=', $token)
            ->first();
    }

    public function updateAccessToken($idUser, $token)
    {
        return \DB::table($this->tableName)
            ->where('idUser', '=', $idUser)
            ->update([
                'accessToken'=> $token
            ]);
    }

    public function removeAccessToken($idUser)
    {
        return \DB::table($this->tableName)
            ->where('idUser', '=', $idUser)
            ->update([
                'accessToken'=> null
            ]);
    }

}