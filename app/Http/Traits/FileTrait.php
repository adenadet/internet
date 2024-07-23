<?php
namespace App\Http\Traits;

trait FileTrait{
    public function file_upload_to_location($file, $file_type, $location, $item_id){
        switch ($file_type){
            case 'image':
                if (!is_null($file)){
                    $image = ((!is_null($item_id)) ? ($item_id."-") : '').time().".".explode('/',explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                    \Image::make($file)->save(public_path($location.'/').$image);
                    $file_url = $image;
                }
                else{
                    $file_url = 'default.png';
                }
            break;
        }

        return $file_url;
    }
}