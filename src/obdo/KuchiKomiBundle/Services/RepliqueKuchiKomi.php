<?php


namespace obdo\KuchiKomiBundle\Services;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
/**
 * Description of RepliqueKuchiKomi
 *
 * @author emilie
 */
class RepliqueKuchiKomi {
   
       
    private $em;
    private $AclManager;
    private $notifier;
    private $namePhoto;
    private $dispatcher;

    


    function __construct($em, $AclManager, $notifier, $namePhoto, $dispatcher) {
        $this->em = $em;
        $this->AclManager = $AclManager;
        $this->notifier = $notifier;
        $this->namePhoto = $namePhoto;
        $this->dispatcher = $dispatcher;
    }

    
    /**
     * Crée le kuchikomi en copiant les éléments issus du KuchiKomiRecurrent en parametre
     * 
     * @param KuchiKomiRecurrent $kuchikomirecurrent
     * @param date $now
     * @param date $begin 
     * @param boolean $actif true par defaut
     * @return $kuchikomi de Type KuchiKomi
     */
    public function createRepeatedKuchiKomi($kuchikomirecurrent,$now,$actif,$send) 
        {
        $begin = $kuchikomirecurrent->getBeginRecurrence();
        $endEve = $kuchikomirecurrent->getEndFirstTime();
        $timeBegin = $kuchikomirecurrent->getBeginTime();
        $dureeheure = $timeBegin->diff($kuchikomirecurrent->getEndTime());            
        $dureejour = $begin->diff($endEve); 
        $kuchikomi= new KuchiKomi();        
        $kuchikomi->setTitle($kuchikomirecurrent->getTitle());
        $kuchikomi->setDetails($kuchikomirecurrent->getDetails()); 
        $kuchikomi->setOrigin(3);
        if($kuchikomirecurrent->getPhotoLink()<>'')
            {           
            $photoname = $this->namePhoto->newName();
            $newPhotolink = $kuchikomirecurrent->getKuchi()->getPhotoKuchiKomiLink().'/'.$photoname; 
            $this->stream_copy('../kuchikomi/web/'.$kuchikomirecurrent->getPhotoLink(), '../kuchikomi/web/'.$newPhotolink);
            $kuchikomi->setPhotoLink($newPhotolink);
            }
                
        $date = new \DateTime();
        $datefin = new \DateTime();
        $date->setDate($now->format('Y'), $now->format('m'), $now->format('d'));
        
        $date->setTime($timeBegin->format('H'), $timeBegin->format('i'),$timeBegin->format('s'));        
        $kuchikomi->setTimestampBegin($date);
        $datefin->setTimestamp($date->getTimestamp());
        $datefin->add($dureejour)->add($dureeheure);
        $kuchikomi->setTimestampEnd($datefin);
        $kuchikomi->setKuchi($kuchikomirecurrent->getKuchi());        
        $kuchikomi->setKuchikomirecurrent($kuchikomirecurrent);        
        if($send = true){
            $this->dispatcher->sendKuchikomiNotificationAsyncEvent($kuchikomi->getKuchi(), $kuchikomi, "2");
        } else {
          $this->notifier->sendKuchikomiNotification($kuchikomi->getKuchi(), $kuchikomi, "3");   
        }
       
        if($actif==false)
            {
            $kuchikomirecurrent->setActive(false);            
            }
        $this->em->persist($kuchikomi);               
        $this->em->flush();     
        
        $this->AclManager->addCascadeUserAcl($kuchikomi);
        
        return $kuchikomi;
    }

    //trouver sur http://php.net/manual/en/function.copy.php
    /**
     * 
     * @param type $src
     * @param type $dest
     * 
     * permet de copier et créer le document destinataire
     */
     public  function stream_copy($src, $dest) 
    { 
        $fsrc = fopen($src,'r'); 
        $fdest = fopen($dest,'w+'); 
        stream_copy_to_stream($fsrc,$fdest); 
        fclose($fsrc); 
        fclose($fdest);          
    }
}
