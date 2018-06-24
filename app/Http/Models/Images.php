<?php

namespace App\Http\Models;

// idImage, idImageCategory, alt, path
use App\Http\Enums\ImageCategories;
use Illuminate\Support\Facades\File;

class Images extends Generic
{
    public function __construct()
    {
        parent::__construct('images', 'idImage');
    }

    //
    // methods
    //

    public function insert($category, $alt, $path)
    {
        $insertData = [
            'idImageCategory' => $category,
            'alt' => $alt,
            'path' => $path,
            'createdAt' => time(),
        ];

        return parent::insertGetId($insertData);
    }

    public function insertScreenShots($idGameSubmission, $idScreenShot)
    {
        return \DB::table('gamesubmissions_screenshots')
            ->insert([
                "idGameSubmission"=>$idGameSubmission,
                "idImage"=> $idScreenShot,
            ]);
    }

    public function removeScreenShots($idGame)
    {
        return \DB::table('gamesubmissions_screenshots')
            ->where('idGameSubmission', '=', $idGame)
            ->delete();
    }

    public function saveFileInFolder($category, $file)
    {
        $extension = $file->getClientOriginalExtension();
        $tmp_path = $file->getPathName();

        $folder = ImageCategories::getSavingFolderByEnum($category);
        $file_name = time() . rand(1, 10) . "." . $extension;
        $new_path = public_path($folder) . $file_name;

        try {
            File::move($tmp_path, $new_path);
            return $folder.$file_name;
        } catch (\ErrorException $ex) {
            return null;
        }
    }

    public function saveImageAndGetId($category, $alt, $photo)
    {
        $filePath = $this->saveFileInFolder($category, $photo);
        if($filePath == null){
            return null;
        }

        return $this->insert($category, $alt, $filePath);
    }

}