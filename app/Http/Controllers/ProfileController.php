<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Models\Roles;
use App\Http\Models\Users;
use App\Http\Models\Images;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit(Request $request){
        $idUser = session()->get('user')[0]->idUser;
        $users = new Users();
        $updateData = [];

        $currentUser = $users->getById($idUser);
        
        // change password
        if(!empty($request->get('tbCurrentPassword')))
        {
            if(md5($request->get('tbCurrentPassword')) === $currentUser->password){
                // update password if field is not empty
                if(!empty($request->get('tbPassword')) && !empty($request->get('tbPassword_confirmation'))){
                    $validacija = Validator::make($request->all(), [
                        'tbPassword' => 'required|confirmed|min:6',
                    ]);
                    $validacija->setAttributeNames([
                        'tbPassword' => 'password',
                    ]);
            
                    if ($validacija->fails()) {
                        // redirekcija na pocetnu i ispis gresaka
                        return back()->withInput()->withErrors($validacija);
                    }

                    $updateData['password'] = md5($request->get('tbPassword'));
                }
            }
            else{
                return back()->withInput()->with('error', 'Wrong password!');
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
            if($e->name != 'admin'){
                $userHasRoles[] = $e->idRole;
            }
        }

        // delete roles
        foreach($userHasRoles as $idRole){
            if(!in_array($idRole, $selectedRoles)  && $idRole !== 1){
                $deleteRoles[] = $idRole;
            }
        }

        foreach($deleteRoles as $idRole){
            $users->deleteRole($idUser, $idRole);
        }
        
        // add roles
        foreach($selectedRoles as $idRole){
            if(!in_array($idRole, $userHasRoles) && $idRole !== 1){
                $newRoles[] = $idRole;
            }
        }

        foreach ($newRoles as $idRole)
        {
            $users->addRole($idRole, $idUser);
        }

        
        $userHasRolesDb = $users->getAllRoles($idUser);

        $request->session()->forget('roles');
        $request->session()->push("roles", $userHasRolesDb);
        //

        // update avatar
        if(!empty($request->file('fAvatarImage'))){
            $photo = $request->file('fAvatarImage');
            $extension = $photo->getClientOriginalExtension();
            $tmp_path = $photo->getPathName();
            
            $folder = 'images/avatars/';
            $file_name = $request->session()->get('user')[0]->username . "_" . time() . "." . $extension;
            $new_path = public_path($folder) . $file_name;

            try {
                // insert avatar image
                File::move($tmp_path, $new_path);

                $updateData['avatarImagePath'] = 'images/avatars/'.$file_name;
            }
            catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
                \Log::error('File error!'.$ex->getMessage());
                return redirect()->back()->with('error','Error with image file!');
            }
            catch(\ErrorException $ex) { 
                \Log::error('File error!'.$ex->getMessage());
                return redirect()->back()->with('error','Error');
            }
        }

        // update user
        $userId = $users->updateUser($idUser, $updateData);

        if(empty($userId))
        {
            return back()->withInput()->with('error', 'Update failed!');
        }

        return back()->withInput()->with('messages', 'Successfully updated!');
    }
}
