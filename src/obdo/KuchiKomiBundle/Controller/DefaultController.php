<?php

namespace obdo\KuchiKomiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('obdoKuchiKomiBundle:Default:index.html.twig');
    }
}
