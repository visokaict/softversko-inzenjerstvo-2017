<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Interfaces\Admin\IUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Models\Generic;
use App\Http\Models\Users;
use App\Http\Models\Polls;

class UpdateController extends AdminController implements IUpdate
{
    private $viewData = [];

    public function users(Request $request) {
        $idUser = $request->get("hiddenId");

        $users = new Users();
        $updateData = [];

        $user = $users->getById($idUser);

        $username = $user->username;

        // change username
        if($user->username !== $request->get("tbUsername")) {
            $validacija = Validator::make($request->all(), [
                'tbUsername' => 'required|unique:users,username'
            ]);
            $validacija->setAttributeNames([
                'tbUsername' => 'username',
            ]);

            if ($validacija->fails()) {
                return response()->json(["message" => "Bad username."], 500);
            }

            $username = $request->get('tbUsername');
            $updateData['username'] = $request->get('tbUsername');
        }

        // change email
        if($user->email !== $request->get("tbEmail")) {
            $validacija = Validator::make($request->all(), [
                'tbEmail' => 'required|email|unique:users,email'
            ]);
            $validacija->setAttributeNames([
                'tbEmail' => 'e-mail',
            ]);

            if ($validacija->fails()) {
                return response()->json(["message" => "Bad e-mail."], 500);
            }

            $updateData['email'] = $request->get('tbEmail');
        }
        
        // change password
        if(!empty($request->get('tbPassword')))
        {
            // update password if field is not empty
            if(!empty($request->get('tbPassword'))){
                $validacija = Validator::make($request->all(), [
                    'tbPassword' => 'required|min:6',
                ]);
                $validacija->setAttributeNames([
                    'tbPassword' => 'password',
                ]);
        
                if ($validacija->fails()) {
                    return response()->json(["message" => "Bad password."], 500);
                }

                $updateData['password'] = md5($request->get('tbPassword'));
            }
        }

        // update roles
        $userRoles = $request->get('userRoles');
        $selectedRoles = [];

        if(!empty($userRoles)){
            foreach($userRoles as $val){
                $selectedRoles[] = (int)$val;
            }
        }

        $userHasRolesDb = $users->getAllRoles($idUser);
        $deleteRoles = [];
        $newRoles = [];
        $userHasRoles = [];

        foreach($userHasRolesDb as $e){
            if($e->name){
                $userHasRoles[] = $e->idRole;
            }
        }

        // delete roles
        foreach($userHasRoles as $idRole){
            if(!in_array($idRole, $selectedRoles)){
                $deleteRoles[] = $idRole;
            }
        }

        foreach($deleteRoles as $idRole){
            $users->deleteRole($idUser, $idRole);
        }
        
        // add roles
        foreach($selectedRoles as $idRole){
            if(!in_array($idRole, $userHasRoles)){
                $newRoles[] = $idRole;
            }
        }

        foreach ($newRoles as $idRole)
        {
            $users->addRole($idRole, $idUser);
        }

        // update avatar
        if(!empty($request->file('fAvatarImage'))){
            $photo = $request->file('fAvatarImage');
            $extension = $photo->getClientOriginalExtension();
            $tmp_path = $photo->getPathName();
            
            $folder = 'images/avatars/';
            $file_name = $username . "_" . time() . "." . $extension;
            $new_path = public_path($folder) . $file_name;

            try {
                // insert avatar image
                File::move($tmp_path, $new_path);

                $updateData['avatarImagePath'] = 'images/avatars/'.$file_name;
            }
            catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
                \Log::error('File error!'.$ex->getMessage());
                return response()->json(["message" => "File error."], 500);
            }
            catch(\ErrorException $ex) { 
                \Log::error('File error!'.$ex->getMessage());
                return response()->json(["message" => "Error."], 500);
            }
        }

        $updateData['isBanned'] = $request->has('chbIsBanned') ? 1 : 0;

        // update user
        $userId = $users->updateUser($idUser, $updateData);

        if(empty($userId))
        {
            return response()->json(["message" => "User not updated!"], 500);
        }

        return AdminController::getAll("users", "ajax.users");
    }

    public function gameCategories(Request $request) {
        return parent::update($request);
    }

    public function gameCriteria(Request $request) {
        return parent::update($request);
    }

    public function reports(Request $request) {
        return parent::update($request);
    }
  
    public function roles(Request $request) {
        return parent::update($request);
    }
  
    public function imageCategories(Request $request) {
        return parent::update($request);
    }
  
    public function platforms(Request $request) {
        return parent::update($request);
    }
  
    public function navigations(Request $request) {
        return parent::update($request);
    }

    public function pollquestions(Request $request) {
        return parent::update($request);
    }

    public function pollanswers(Request $request) {
        return parent::update($request);
    }

    public function setActivePollQuestion(Request $request) {
        $model = new Polls();
        $model->setActivePollQuestion($request->get("id"));

        return AdminController::getAll("pollquestions", "ajax.polls");
    }

}