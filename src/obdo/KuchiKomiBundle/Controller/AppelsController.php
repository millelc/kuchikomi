<?php

namespace obdo\KuchiKomiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\KuchiKomiRESTBundle\Entity\AppelsRepository;
use obdo\KuchiKomiRESTBundle\Entity\Appels;
use obdo\KuchiKomiRESTBundle\Entity\TypeAppel;
use obdo\KuchiKomiRESTBundle\Form\AppelFormType;
use obdo\KuchiKomiRESTBundle\Form\AppelForm;
use obdo\KuchiKomiRESTBundle\Entity\SqlStat;

/**
 * Description of AppelsController
 *
 * @author frederic
 */
class AppelsController extends Controller{
    public function indexAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        
        $appels = $em->getRepository('obdoKuchiKomiRESTBundle:Appels')
                ->getAppelsList(25, $page, $sort);

        return $this->render('obdoKuchiKomiBundle:Default:appelsindex.html.twig', array(
                    'appels' => $appels,
                    'page' => $page,
                    'nombrePage' => ceil(count($appels) / 25),
                    'sort' => $sort
        ));
    }
    
    public function viewAction($id)
    {
        $appel = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Appels')
                ->find($id);
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($appel->getClient());
       
        return $this->render('obdoKuchiKomiBundle:Default:appelsview.html.twig', array(
                    'raissoc' => $client->getRaissoc(),
                    'Appel' => $appel
        ));
    }
    
    public function addAction()
    {
        $Logger = $this->container->get('obdo_services.Logger');
        
        $msgerr = '';
        $nouveautype = false;
        $appelform = new AppelForm();
        $appelform->setDateappel(new \DateTime());
        $form = $this->createForm(new AppelFormType, $appelform);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $appel = new Appels();
                if ($appelform->getTypeappel() == null && $appelform->getNewtype() == null){
                    $msgerr = "Le type d'appel est obligatoire";
                }else{ // sinon on aliemente le type d'appel avec création éventuelle d'un nouveau type.
                    if ($appelform->getNewtype() != null){//Si saisie pas null on cherche si existe déjà                       
                        $newtype = $this->getDoctrine()
                                    ->getRepository('obdo\KuchiKomiRESTBundle\Entity\TypeAppel')
                                    ->findByDescription($appelform->getNewtype()); 
                        // si pas trouvé création
                        if (!$newtype){
                        $newtype = new TypeAppel();    
                        $newtype->setDescription($appelform->getNewtype());
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($newtype);
                        $em->flush();
                        $appel->setTypeappel($newtype);
                        }
                    }else{
                        $appel->setTypeappel($appelform->getTypeappel());
                    }
                    // on alimente les champs d l'entité appel avec le contenu du formulaire
                    $appel->setDateappel($appelform->getDateappel());
                    $appel->setClient($appelform->getClient());
                    $appel->setNomcorresp($appelform->getNomcorresp());
                    $appel->setTelcorresp($appelform->getTelcorresp());
                    $appel->setTitreappel($appelform->getTitreappel());
                    $appel->setRaisonappel($appelform->getRaisonappel());
                    $appel->setSolution($appelform->getSolution());
                    $appel->setTemps($appelform->getTemps());
              
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($appel);
                    $em->flush();

                    $Logger->Info("[Appels] [user : " . $this->get('security.context')
                            ->getToken()->getUser()->getUserName() . "] " . $appel->getTitreappel() . " added");

                    return $this->redirect($this->generateUrl('obdo_kuchi_komi_appel', array(
                                        'page' => 1,
                                        'sort' => 'date_up'
                    )));
                }
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:appelsadd.html.twig', array(
                        'form' => $form->createView(),
                        'action' => 'Ajouter',
                        'msgerr' => $msgerr
            )); 
    }
    
    /*
     * Stats sur les appels, détail/clients dans ClientsController
     */
    public function suiviAction(){
        //Somme de tous les appels
        $nbappels = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Appels')
                ->getNbAppels();
        
        //Temps total de tous les appels
        $tempstotal = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Appels')
                ->getTempsTotal();
        
        //temps moyen
        $tempsmoyen = 0;
        if ($nbappels != 0){
            $tempsmoyen = ceil($tempstotal/$nbappels);
        }
        
    // Calculs pour l'année en cours
        $datedeb = new \DateTime(); 
        $datefin = new \DateTime();
        // n° du jour de l'année
        $nojouran = date('z',$datedeb->getTimestamp());
        $deltadeb = -($nojouran).' day' ;
        $deltafin = (365 - $nojouran).' day';
        // on positionne date debut au 01 Janvier et date fin au 1 janvier année suivante
        $datedeb->modify($deltadeb);
        $datefin->modify($deltafin);
        
        $appelsans = SqlStat::getAppelsDateAn(date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);
        
        $nbappelan = 0;
        $tempstotalan = 0;
        $tempsmoyenan = 0;
        // si il y a eu des appels on somme
        if($appelsans){
            foreach($appelsans as $appelsan){
                $nbappelan += $appelsan['nbre'];
                $tempstotalan += $appelsan['ttemps'];
            }
        }
        if ($nbappelan !=0){
            $tempsmoyenan = ceil($tempstotalan/$nbappelan);
        }
        
        return $this->render('obdoKuchiKomiBundle:Default:appelsuivi.html.twig', array(
                            'nbappel' => $nbappels,
                            'tempstotal' => $tempstotal,
                            'tempsmoyen' => $tempsmoyen,
                            'nbappelan' => $nbappelan,
                            'tempstotalan' => $tempstotalan, 
                            'tempsmoyenan' => $tempsmoyenan,
             )); 
    }
    
}
