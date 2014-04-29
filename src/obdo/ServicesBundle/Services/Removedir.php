<?php

/**
 * Description of Pictureuploader
 *
 * @author frederic
 */

namespace obdo\ServicesBundle\Services;

class Removedir {

    public function __construct() {
        
    }

    /*
     * rrmdir
     * supprime le repertoire($dir) et son contenu
     */

    public function rrmdir($dir) {

        if (file_exists($dir)) {
            foreach (glob($dir . '/*') as $file) {
                if (is_dir($file))
                    rrmdir($file);
                else
                    unlink($file);
            }
            rmdir($dir);
        }
    }

}
