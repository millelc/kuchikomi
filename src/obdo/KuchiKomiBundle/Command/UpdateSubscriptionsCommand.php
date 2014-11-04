<?php

namespace obdo\KuchiKomiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;

class UpdateSubscriptionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('subscription:update')
             ->setDescription('Update subscription to CityKomi group and News kuchi from NFC to Web');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $notifier = $this->getContainer()->get('obdo_services.Notifier');
        $logger = $this->getContainer()->get('obdo_services.Logger');
        
        $repositoryKuchiGroup = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        $kuchiGroupCityKomi = $repositoryKuchiGroup->findOneById($this->getContainer()->getParameter('CityKomiGroupId'));
        
        $count = 0;
        
        foreach ($kuchiGroupCityKomi->getSubscriptions() as $subscriptionGroup)
        {
            $subscriptionGroup->setType(SubscriptionGroup::TYPE_WEB);
            $em->persist($subscriptionGroup);
            $count = $count + 1;
        }
        
        foreach($kuchiGroupCityKomi->getKuchis() as $kuchi)
        {
            foreach ($kuchi->getSubscriptions() as $subscription)
            {
                $subscription->setType(Subscription::TYPE_WEB);
                $em->persist($subscription);
                $count = $count + 1;
            }
        }
        
        $em->flush();
        
        $logger->Info("[UPDATE SUBSCRIPTION] " . $count . " subscription(s) updated");
    }
}
