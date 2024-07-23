<?php
namespace App\Http\Traits;

trait FileManagementTrait{
    public function file_upload($file, $file_type, $location, $id){
        switch ($file_type){
            case 'image':
                $file_url = null;
                if (!is_null($file)){
                    $image = ((!is_null($id)) ? $id."-" : '').time().".".explode('/',explode(':', substr( $file, 0, strpos($file, ';')))[1])[1];
                    \Image::make($file)->save(public_path($location).$image);
                    $file_url = $image;
                }
                else{
                    $file_url = "default.png";
                }
            break;
            case 'pdf':
                $file_url = $id."-".time().'.pdf';
                $dent = explode("base64,", $file);
                $dustbin = base64_decode($dent[1], true);
                file_put_contents((public_path($location).'/'.$file_url), $dustbin);
            break;    
        }
        return $file_url;
    }
}