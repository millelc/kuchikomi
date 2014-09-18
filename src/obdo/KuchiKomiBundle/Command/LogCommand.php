<?php

namespace obdo\KuchiKomiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LogCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('Log:test')
             ->setDescription('Test de log');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('obdo_services.Logger');
        
        
        $logger->Warning("Essai Log");
    }
}
