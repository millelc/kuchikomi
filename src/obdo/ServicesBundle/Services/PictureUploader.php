<?php

/**
 * Description of Pictureuploader
 *
 * @author frederic
 */
namespace obdo\ServicesBundle\Services;

use \Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureUploader {
 

    public function __construct()
    {
        
    }

    public function upload(UploadedFile $file, $directory, $name)
    {
        
        if (!$file instanceof UploadedFile) {
            throw new \InvalidArgumentException(
                    'There is no file to upload!'
            );
        }
        if ($name == ''){
           $name = $file->getClientOriginalName(); 
        }
        
        $file->move($directory, $name);
        $last = $directory[strlen($directory)-1]; 
        if ($last == '/'){
          $logo = $directory.$name;  
        }
        else{
            $logo = $directory.'/'.$name;
        }
        
        return $logo;
    }

}
