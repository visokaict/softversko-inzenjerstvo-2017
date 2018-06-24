<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Interfaces\Admin\IInsert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Models\Generic;
use App\Http\Models\Users;

class InsertController extends AdminController implements IInsert
{
    private $viewData = [];
    
    public function users(Request $request)
    {
        $validacija = Validator::make($request->all(), [
            'tbEmail' => 'required|email|unique:users,email',
            'tbUsername' => 'required|unique:users,username',
            'tbPassword' => 'required|min:6',
        ]);
        $validacija->setAttributeNames([
            'tbEmail' => 'email',
            'tbUsername' => 'username',
            'tbPassword' => 'password',
        ]);

        if ($validacija->fails()) {
            return response()->json(["error" => ["message" => $validacija]], 500);
        }

        $userRoles = $request->get('userRoles');
        $user = new Users();

        $avatar = null;

        if(!empty($request->file('fAvatarImage'))){
            $photo = $request->file('fAvatarImage');
            $extension = $photo->getClientOriginalExtension();
            $tmp_path = $photo->getPathName();
            
            $folder = 'images/avatars/';
            $file_name = "changed" . "_" . time() . "." . $extension;
            $new_path = public_path($folder) . $file_name;

            try {
                // insert avatar image
                File::move($tmp_path, $new_path);

                $avatar = 'images/avatars/'.$file_name;
            }
            catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
                \Log::error('File error!'.$ex->getMessage());
                return response()->json(["error" => ["message" => "File error!"]], 500);
            }
            catch(\ErrorException $ex) { 
                \Log::error('File error!'.$ex->getMessage());
                return response()->json(["error" => ["message" => "Error!"]], 500);
            }
        }

        $isBanned= $request->has('isBanned') ? 1 : 0;

        $userId = $user->insert(
            strtolower($request->get('tbEmail')),
            strtolower($request->get('tbUsername')),
            $request->get('tbPassword'),
            $isBanned,
            $avatar
        );

        //something went wrong and user isn't inserted
        if (empty($userId)) {
            return response()->json(["message" => "User not updated!"], 500);
        }

        //add roles
        if (!empty($userRoles)) {
            foreach ($userRoles as $role) {
                $user->addRole($role, $userId);
            }
        }

        return AdminController::getAll("users", "ajax.users");
    }

    public function gameCategories(Request $request) {
        return parent::insert($request);
    }

    public function gameCriteria(Request $request) {
        return parent::insert($request);
    }

    public function roles(Request $request) {
        return parent::insert($request);
    }
  
    public function imageCategories(Request $request) {
        return parent::insert($request);
    }

    public function platforms(Request $request) {
        return parent::insert($request);
    }

    public function navigations(Request $request) {
        return parent::insert($request);
    }

    public function pollquestions(Request $request) {
        return parent::insert($request);
    }

    public function pollanswers(Request $request) {
        return parent::insert($request);
    }

}