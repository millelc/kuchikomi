<?php

namespace obdo\KuchiKomiRESTBundle\Services;


class idCheck
{
    public function isPostKomiValid( $id )
    {
        return ( preg_match("#^%%OB-DO-2-0-0%%#", $id) AND // Commence par %%OB-DO-2-0-0%%
                 preg_match("#%%ID%%#", $id) AND           // Contient %%ID%%
                 preg_match("#%%OB-DO-2-0-0%%$#", $id));   // Termine par %%OB-DO-2-0-0%%
    }

    public function isDeleteKomiValid( $id )
    {
        return ( preg_match("#^%%OB-DO-2-0-0%%#", $id) AND // Commence par %%OB-DO-2-0-0%%
                 preg_match("#%%OB-DO-2-0-0%%$#", $id));   // Termine par %%OB-DO-2-0-0%%
    }
    
    public function isPostAuthenticateValid( $id )
    {
        return ( preg_match("#^%%OB-DO-2-0-0%%#", $id) AND // Commence par %%OB-DO-2-0-0%%
                 preg_match("#%%OB-DO-2-0-0%%$#", $id));   // Termine par %%OB-DO-2-0-0%%
    }
    
    public function getPostKomiMobileOsId( $id )
    {
        preg_match("#\%%OB-DO-2-0-0%%(.+)\%%ID%%#", $id, $mobileOsId);
        
        return $mobileOsId[1];
    }
    
    public function getPostKomiRandomId ($id )
    {
        preg_match("#\%%ID%%(.+)\%%OB-DO-2-0-0%%#", $id, $randomId);
        
        return $randomId[1];
    }
    
    public function getDeleteKomiRandomId ($id )
    {
        preg_match("#\%%OB-DO-2-0-0%%(.+)\%%OB-DO-2-0-0%%#", $id, $randomId);
        
        return $randomId[1];
    }

    public function getPostAuthenticateRandomId ($id )
    {
        preg_match("#\%%OB-DO-2-0-0%%(.+)\%%OB-DO-2-0-0%%#", $id, $randomId);
        
        return $randomId[1];
    }

}
