<?php

/**
 * Description of NamePhoto
 * Retourne un nom unique
 *
 * @author frederic
 */
namespace obdo\ServicesBundle\Services;


class NamePhoto {
 

    public function __construct()
    {
        
    }

    public function newName()
    {
        return md5(uniqid(rand(), true)) . '.jpg';
    }

}
