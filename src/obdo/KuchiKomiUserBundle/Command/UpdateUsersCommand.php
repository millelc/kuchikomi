<?php

namespace obdo\KuchiKomiUserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUsersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('users:update')
             ->setDescription('Update des tables Users de Kuchi et KuchiGroup');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $AclManager = $this->getContainer()->get('obdo_services.AclManager');
        
        // Update all users
        $repositoryKuchiGroup = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        
        $kuchiGroups = $repositoryKuchiGroup->findAll();
        foreach($kuchiGroups as $kuchiGroup)
        {
            $kuchiGroupUsers = $kuchiGroup->getUsers();
            foreach($kuchiGroupUsers as $kuchiGroupUser)
            {
                $kuchis = $kuchiGroup->getKuchis();
                foreach($kuchis as $kuchi)
                {
                    if( $kuchi->getUsers()->contains($kuchiGroupUser))
                    {
                        $text = "User " . $kuchiGroupUser->getUsername() . " already present for kuchi " . $kuchi->getName();
                    }
                    else
                    {
                        $text = "Add User " . $kuchiGroupUser->getUsername() . " to kuchi " . $kuchi->getName();
                        $kuchi->addUser($kuchiGroupUser);
                    }
                    $output->writeln($text);
                }
            }
        }
        
        //Update Acl
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $kuchiKomis = $repositoryKuchiKomi->findAll();
        foreach($kuchiKomis as $kuchikomi)
        {
            foreach($kuchikomi->getKuchi()->getUsers() as $user)
            {
                $AclManager->addAcl($kuchikomi, $user);
                $text = "Add ACL (" . $kuchikomi->getTitle() . ":" . $user->getUsername() . ")";
                $output->writeln($text);
            }
            foreach($kuchikomi->getKuchi()->getKuchiGroup()->getUsers() as $user)
            {
                $AclManager->addAcl($kuchikomi, $user);
                $text = "Add ACL (" . $kuchikomi->getTitle() . ":" . $user->getUsername() . ")";
                $output->writeln($text);
            }            
        }

        $em->flush();
    }
}
