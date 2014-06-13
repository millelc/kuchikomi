<?php

namespace obdo\KuchiKomiMenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainMenuController extends Controller
{
    public function mainMenuAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))
        {
            return $this->render('obdoKuchiKomiMenuBundle:Default:mainMenuSuperAdmin.html.twig');
        }
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            return $this->render('obdoKuchiKomiMenuBundle:Default:mainMenuAdmin.html.twig');
        }
        elseif ($this->get('security.context')->isGranted('ROLE_ADMIN_GROUP_KUCHI'))
        {
            return $this->render('obdoKuchiKomiMenuBundle:Default:mainMenuAdminGroupKuchi.html.twig');
        }
        elseif ($this->get('security.context')->isGranted('ROLE_KUCHI'))
        {
            return $this->render('obdoKuchiKomiMenuBundle:Default:mainMenuKuchi.html.twig');
        }
        else
        {
            return $this->render('obdoKuchiKomiMenuBundle:Default:mainMenu.html.twig');
        }
    }
}
