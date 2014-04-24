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

    public function upload(UploadedFile $file, $directory)
    {
        
        if (!$file instanceof UploadedFile) {
            throw new \InvalidArgumentException(
                    'There is no file to upload!'
            );
        }
        $name = $file->getClientOriginalName();

        $file->move($directory, $name);
        
        $logo = $directory.'/'.$name;
        
        return $logo;
    }

}
