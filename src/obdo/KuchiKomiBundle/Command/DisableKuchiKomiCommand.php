<?php

namespace obdo\KuchiKomiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DisableKuchiKomiCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('kuchikomi:disable')
             ->setDescription('Disable the Kuchikomi dont la date de fin est supérieure à 15 jours de la date actuelle');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $notifier = $this->getContainer()->get('obdo_services.Notifier');
        $logger = $this->getContainer()->get('obdo_services.Logger');
        
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $kuchikomis = $repositoryKuchiKomi->getKuchiKomisToDisable();
        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        foreach ($kuchikomis as $kuchikomi)
        {
            $kuchikomi->setTimestampSuppression($currentDate);
            $kuchikomi->setActive(false);
            
            // Envoie d'une notification silencieuse
            $kuchi = $repositoryKuchi->find($kuchikomi->getKuchiId());
            $notifier->sendKuchiKomiNotification($kuchi, $kuchikomi, "3");
        }
        
        if(count($kuchikomis)>0)
        {
            $em->flush();
        }
        
        $logger->Info("[DISABLE KUCHIKOMI] " . count($kuchikomis) . " KuchiKomi(s) désactivé(s)");
    }
}
