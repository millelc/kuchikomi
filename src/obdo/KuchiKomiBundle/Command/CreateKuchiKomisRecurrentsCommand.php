<?php
namespace obdo\KuchiKomiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent;



/**
 * Description of CreateKuchiKomisRecurrentsCommand
 *
 * @author emilie
 */
class CreateKuchiKomisRecurrentsCommand extends ContainerAwareCommand {
    
    private $em;
    private $notifier;
    private $AclManager;
    private $path; 
           
    
   
    protected function configure() {
        parent::configure();        
        $this->setName('kuchikomirecurrent:createkuchikomi');        
        
    }

    protected function execute(InputInterface $input, OutputInterface $output) {                
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->notifier = $this->getContainer()->get('obdo_services.Notifier');
        $logger = $this->getContainer()->get('obdo_services.Logger');
        $this->AclManager= $this->getContainer()->get('obdo_services.AclManager');
        $this->path = $this->getContainer()->getParameter('path_kuchikomi_photo');
               
        
        $repositoryKuchiKomiRecu = $this->em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomiRecurrent');
        
        
        $kuchikomirecurrents = $repositoryKuchiKomiRecu->findBy(array('active'=> true));
        $now = new \DateTime('now', new \DateTimeZone('Europe/Paris')) ;        
        $count=0;
        
        foreach ($kuchikomirecurrents as $kuchikomirecurrent ){
                $recurrence = $kuchikomirecurrent->getRecurrence();                        
                $begin = $kuchikomirecurrent->getBeginRecurrence();
                $end = $kuchikomirecurrent->getEndRecurrence();    
                //$end->setTime('23','59','59');
                
                
                if($kuchikomirecurrent->getSendDay()>0) 
                {
                    $inter= new \DateInterval('P'.$kuchikomirecurrent->getSendDay().'D');
                    $now=$now->add($inter);                             
                }   
                $jour = $now->format('w');
                $jourmois = $now->format('d');  
                $year = $now->format('Y');
                $mois = $now->format('m');


                if($begin <= $now && $now <= $end){
                    switch($recurrence)
                    {                        
                        case "weekly":
                            {                         
                            if($jour==$begin->format('w'))
                                {
                                $kuchikomi = $this->createRepeatedKuchiKomi($kuchikomirecurrent, $now,$begin,true);
                                $count= $count+1;
                                $output->write('$kuchikomi '.$kuchikomi->getId().' hebdo créé');
                                }
                            break;
                            }
                        case "monthly":
                            {                             
                            if($jourmois==$begin->format('d'))
                                {
                                $kuchikomi = $this->createRepeatedKuchiKomi($kuchikomirecurrent, $now,$begin,true );
                                $logger->Info('$kuchikomi '.$kuchikomi->getId().' mensuel créé');
                                $count= $count+1;
                                }
                            break;
                            }
                        case "unique":
                            {
                            if($jour==$begin->format('w') && $mois==$begin->format('m') && $year==$begin->format('Y'))
                                {
                                $kuchikomi = $this->createRepeatedKuchiKomi($kuchikomirecurrent, $now,$begin,false );                        
                                $logger->Info('Message pré-enregistré n°'.$kuchikomirecurrent->getId().' a bien été envoyé');
                                $logger->Info('$kuchikomi '.$kuchikomi->getId().' unique créé');
                                }  
                            break;
                            }
                        case "yearly":
                        {
                            if($jour==$begin->format('w') && $mois==$begin->format('m')){
                                $kuchikomi = $this->createRepeatedKuchiKomi($kuchikomirecurrent, $now,$begin,true);
                                $count= $count+1;
                                $logger->Info('$kuchikomi '.$kuchikomi->getId().' annuel créé');
                            }
                            break;
                        }
                    }
                }
                elseif($now > $end)
                    {
                    $kuchikomirecurrent->setActive(false);
                    $this->em->persist($kuchikomirecurrent);               
                    $this->em->flush();
                    }
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris')) ;
            }
        
        $logger->Info($count.' Kuchikomis créés');
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
    public function createRepeatedKuchiKomi($kuchikomirecurrent,$now,$begin,$actif=true) 
        {
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
            $photoname = $this->getContainer()->get('obdo_services.Name_photo')->newName();
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
        $this->notifier->sendKuchikomiNotification($kuchikomi->getKuchi(), $kuchikomi, "2");
        if($actif==false)
            {
            $kuchikomirecurrent->setActive(false);
            $this->em->persist($kuchikomirecurrent);
            }
        $this->em->persist($kuchikomi);               
        $this->em->flush();     
        
        foreach($kuchikomi->getKuchi()->getUsers() as $user)
            {            
           $this->AclManager->addAcl($kuchikomi, $user);           
            }
        foreach($kuchikomi->getKuchi()->getKuchiGroup()->getUsers() as $user)
            {
            $this->AclManager->addAcl($kuchikomi, $user);
            }
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

