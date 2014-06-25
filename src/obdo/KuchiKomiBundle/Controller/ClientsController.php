<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\KuchiKomiRESTBundle\Form\ClientsType;
use obdo\KuchiKomiUserBundle\Entity\User;
use obdo\KuchiKomiUserBundle\Entity\UserRepository;
use obdo\KuchiKomiRESTBundle\Entity\SqlStat;
	
class ClientsController extends Controller{
    
    public function indexAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        
        $clients = $em->getRepository('obdoKuchiKomiRESTBundle:Clients')
                ->getClientsList(25, $page, $sort);

        return $this->render('obdoKuchiKomiBundle:Default:clientsindex.html.twig', array(
                    'clients' => $clients,
                    'page' => $page,
                    'nombrePage' => ceil(count($clients) / 25),
                    'sort' => $sort
        ));
    }
    
    public function addAction() {
        $Logger = $this->container->get('obdo_services.Logger');
        
        $client = new Clients();
        $form = $this->createForm(new ClientsType, $client);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();
                
                $Logger->Info("[Clients] [user : " . $this->get('security.context')
                        ->getToken()->getUser()->getUserName() . "] " . $client->getRaissoc() . " added");
                
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_client', array(
                                    'page' => 1,
                                    'sort' => 'name_up'
                )));
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:clientsadd.html.twig', array(
                        'form' => $form->createView(),
                        'action' => 'Ajouter',
            ));
    }
    
    public function viewAction($id) {
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($id);
        $users = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiUserBundle\Entity\User')
                ->findByClient($id);
        $abonnements = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Abonnements')
                ->findByClient($id);
        return $this->render('obdoKuchiKomiBundle:Default:clientsview.html.twig', array(
                    'Client' => $client,
                    'Users' => $users,
                    'Abonnements' => $abonnements,
        ));
    }
    
    public function updateAction($id) {
        $Logger = $this->container->get('obdo_services.Logger');
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($id);
        $form = $this->createForm(new ClientsType, $client);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();
                
                $Logger->Info("[Clients] [user : " . $this->get('security.context')
                        ->getToken()->getUser()->getUserName() . "] " . $client->getRaissoc() . " updated");
                
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_client', array(
                                    'page' => 1,
                                    'sort' => 'name_up'
                )));
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:clientsadd.html.twig', array(
                        'form' => $form->createView(),
                        'action' => 'Mise à jour',
            ));
    }
    /*
     * Ajout users existant à un client.
     */
    public function userAction($clientid){
        $Logger = $this->container->get('obdo_services.Logger');
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($clientid);

        $a = array();
        // on genere le formulaire liste des users
        $formulaire = $this->createFormBuilder($a)
                        ->add('users', 'entity', array(
                                'class'    => 'obdoKuchiKomiUserBundle:User',
                                'property' => 'username',
                                'multiple' => true ,
                                'required' => false,
                                'query_builder' => function(UserRepository $r)
                                {
                                return $r->getUsersForForm();
                                }));
        $form = $formulaire->getForm();
        // On récupère la requête
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                 if ($form['users']->getData() != null) {
                        foreach ($form['users']->getData() as $k) {
                            $k->setClient($clientid);
                            
                            $Logger->Info("[Clients] [user : " . $this->get('security.context')
                            ->getToken()->getUser()->getUserName() . "] " 
                            . $client->getRaissoc() . " [user] ".$k->getUserName()." added");
                        }
                        $em = $this->getDoctrine()->getManager();
                        $em->flush();
                    }
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_client_view', array(
                                        'id' => $clientid,
                    )));
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:clientuser.html.twig', array(
                         'form' => $form->createView(),
                         'action' => 'Ajout User',
                         'client' => $client,
             )); 
    }
    /*
     * Retire un user au client
     */
    public function userremoveAction($clientid, $userid){
        $Logger = $this->container->get('obdo_services.Logger');
        
        $user = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiUserBundle\Entity\User')
                ->find($userid);
        
        //uniquement la pour le log
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($clientid);
        
        // si on à trouvé le user
        if ($user){
            $user->setClient(null);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $Logger->Info("[Clients] [user : " . $this->get('security.context')
                            ->getToken()->getUser()->getUserName() . "] " 
                            . $client->getRaissoc() . " [user] ".$user->getUserName()." removed");
        }
        // et on réaffiche le client
        return $this->redirect($this->generateUrl('obdo_kuchi_komi_client_view', array(
                                        'id' => $clientid,
                    )));
    }
    /*
     * Quelques stats de suivi du client
     */
    public function suiviAction($clientid) {
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($clientid);
        
        $em = $this->getDoctrine()->getManager();
        
        //total kuchikomis du client
        $nbKuchikomis = SqlStat::getNbKuchiKomiByClientId($clientid, $this);
        $totalKuchiKomis = 0;
        foreach ($nbKuchikomis as $nbKuchikomi){
            $totalKuchiKomis = $nbKuchikomi['nbkuchikomi'];
        }
        
        //taille images du client
        $size = 0;
        $abonnements = $em->getRepository('obdoKuchiKomiRESTBundle:Abonnements')->findByClient($clientid);
        foreach ($abonnements as $abonnement){
            $kuchis = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi')->findByAbonnement($abonnement->getId());
            foreach ($kuchis as $kuchi){
                $kuchikomis = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi')->findByKuchi($kuchi);
                foreach ($kuchikomis as $kuchikomi){
                    if ($kuchikomi->getPhotoLink() != null)
                        $size += filesize($kuchikomi->getPhotoLink());
                }
                if ($kuchi->getLogoLink() != null)
                    $size += filesize($kuchi->getLogoLink());
                if ($kuchi->getPhotoLink() != null)
                    $size += filesize($kuchi->getPhotoLink());
            }
        }
        
        // taille moyenne des messages du client
        $avgKuchikomis = SqlStat::getAvgDetailClient($clientid, $this);
        $moyenne = 0;
        foreach ($avgKuchikomis as $avgKuchikomi){
            $moyenne = $avgKuchikomi['moyenne'];
        }
        
        return $this->render('obdoKuchiKomiBundle:Default:clientsuivi.html.twig', array(
                            'nomcli' => $client->getRaissoc(),
                            'totalKuchiKomis' => $totalKuchiKomis,
                            'tailleimage' => round($size/(1024*1024),3),
                            'moyenne' => round($moyenne),
                            'clientid' => $clientid
             )); 
    }
}