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
    
         
    
   
    protected function configure() {
        parent::configure();        
        $this->setName('kuchikomirecurrent:createkuchikomi');        
        
    }

    protected function execute(InputInterface $input, OutputInterface $output) {                
        $em = $this->getContainer()->get('doctrine')->getManager();
        $logger = $this->getContainer()->get('obdo_services.Logger');
        $replique = $this->getContainer()->get('obdo_kuchi_komi.replique');
                       
        $repositoryKuchiKomiRecu = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomiRecurrent');
                
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
                                $kuchikomi = $replique->createRepeatedKuchiKomi($kuchikomirecurrent, $now,true,false);
                                $count= $count+1;
                                $output->write('$kuchikomi '.$kuchikomi->getId().' hebdo créé');
                                }
                            break;
                            }
                        case "monthly":
                            {                             
                            if($jourmois==$begin->format('d'))
                                {
                                $kuchikomi = $replique->createRepeatedKuchiKomi($kuchikomirecurrent, $now,true,false );
                                $logger->Info('$kuchikomi '.$kuchikomi->getId().' mensuel créé');
                                $count= $count+1;
                                }
                            break;
                            }
                        case "unique":
                            {
                            if($jour==$begin->format('w') && $mois==$begin->format('m') && $year==$begin->format('Y'))
                                {
                                $kuchikomi = $replique->createRepeatedKuchiKomi($kuchikomirecurrent, $now,false,false );                        
                                $logger->Info('Message pré-enregistré n°'.$kuchikomirecurrent->getId().' a bien été envoyé');
                                $logger->Info('$kuchikomi '.$kuchikomi->getId().' unique créé');
                                }  
                            break;
                            }
                        case "yearly":
                        {
                            if($jour==$begin->format('w') && $mois==$begin->format('m')){
                                $kuchikomi = $replique->createRepeatedKuchiKomi($kuchikomirecurrent, $now,true,false);
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
                    $em->persist($kuchikomirecurrent);               
                    $em->flush();
                    }
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris')) ;
            }
        
        $logger->Info($count.' Kuchikomis créés');
    }


}

