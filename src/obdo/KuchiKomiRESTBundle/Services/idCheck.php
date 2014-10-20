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

    public function isPostAuthenticateKuchiValid( $id )
    {
    	return ( preg_match("#^%%OB-DO-2-0-0%%#", $id) AND // Commence par %%OB-DO-2-0-0%%
                 preg_match("#%%ID_KUCHI%%#", $id) AND       // Contient %%ID_KUCHI%%
    		 preg_match("#%%ID_PWD%%#", $id) AND       // Contient %%ID_PWD%%
    		 preg_match("#%%OB-DO-2-0-0%%$#", $id));   // Termine par %%OB-DO-2-0-0%%
    }
    


    public function getPostAuthenticateKuchiRandomId( $id )
    {
    	preg_match("#\%%OB-DO-2-0-0%%(.+)\%%ID_KUCHI%%#", $id, $randomId);
        if(!$randomId)
        {
            return $randomId;
        }
        else
        {
    	return $randomId[1];
        }
    }
    
    public function getPostAuthenticateKuchiId( $id )
    {
    	preg_match("#\%%ID_KUCHI%%(.+)\%%ID_PWD%%#", $id, $kuchiId);
        if(!$kuchiId){
            return  $kuchiId; 
        }
        else
        {
            return $kuchiId[1];
        }
    }
    
    public function getPostAuthenticateKuchiPassword( $id )
    {
    	preg_match("#\%%ID_PWD%%(.+)\%%OB-DO-2-0-0%%#", $id, $password);
        if(!$password){
          return $password;  
        } 
        else 
        {
          return $password[1];  
        }
    	
    }

    public function getPostKomiMobileOsId( $id )
    {
        preg_match("#\%%OB-DO-2-0-0%%(.+)\%%ID%%#", $id, $mobileOsId);
        if(!$mobileOsId){
            return $mobileOsId;
        }
        else
        {
            return $mobileOsId[1];  
        }        
    }
    
    public function getPostKomiRandomId ($id )
    {
        
        preg_match("#\%%ID%%(.+)\%%OB-DO-2-0-0%%#", $id, $randomId);
        if(!$randomId){
            return $randomId;
            }
        else
            {
           return $randomId[1]; 
            }   
        
    }
    
    public function getDeleteKomiRandomId ($id )
    {
        preg_match("#\%%OB-DO-2-0-0%%(.+)\%%OB-DO-2-0-0%%#", $id, $randomId);
        if(!$randomId){
            return $randomId;
            }
        else
            {
           return $randomId[1]; 
            }
    }

    public function getPostAuthenticateRandomId ($id )
    {
        preg_match("#\%%OB-DO-2-0-0%%(.+)\%%OB-DO-2-0-0%%#", $id, $randomId);
        if(!$randomId){
            return $randomId;
            }
        else
            {
           return $randomId[1]; 
            }
    }
    
    public function getVersion( $id )
    {
        if( preg_match("#^%%OB-DO-2-0-0%%#", $id) )
        {
            $version = "2.0.0";
        }
        else
        {
            $version = "0.0.0";
        }
        
        return $version;
    }

}
