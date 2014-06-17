<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Abonnements;
use obdo\KuchiKomiRESTBundle\Entity\KuchiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\KuchiKomiRESTBundle\Form\AbonnementsType;

/**
 * Description of Abonnements
 *
 * @author frederic
 */
class AbonnementsController extends Controller{
    /*
     * Ajout d'un abonnement depuis un client
     */
    public function addAction($clientid) {
        $Logger = $this->container->get('obdo_services.Logger');
        
        $msgd = '';
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($clientid); 
        $abonnement = new Abonnements();
        // on passe les dates à la date du jour
        $abonnement->setDatedebabo(new \DateTime());
        $abonnement->setDatefinabo(new \DateTime());
        $form = $this->createForm(new AbonnementsType, $abonnement);
        // on affecte le client à l'abonnement
        $abonnement->setClient($clientid);
        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // on verifie que la date de début est inférieure ou  égale à la date de fin
                if ($abonnement->getDatefinabo() < $abonnement->getDatedebabo()){
                    $msgd = 'La fin ne peut avoir lieu avant le commencement';
                }else{
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($abonnement);
                    $em->flush();

                    $Logger->Info("[Abonnement] [user : " . $this->get('security.context')
                            ->getToken()->getUser()->getUserName() . "] " . $abonnement->getTitreabo() . " added");

                    return $this->redirect($this->generateUrl('obdo_kuchi_komi_client_view', array(
                                        'id' => $clientid,
                    )));
                }
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:abonnementsadd.html.twig', array(
                        'form' => $form->createView(),
                        'action' => 'Ajouter',
                        'client' => $client,
                        'ErrMsgd' => $msgd,
            ));
    }
    /*
     * Affiche le détail d'un abonnement
     */
    public function viewAction($id) {
        $abonnement = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Abonnements')
                ->find($id);
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($abonnement->getClient());
        
        $kuchis = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->findByAbonnement($id);
        
        $hidden = $this->btnafficheAddKushi($abonnement);
        
        return $this->render('obdoKuchiKomiBundle:Default:abonnementsview.html.twig', array(
                    'Abonnement' => $abonnement,
                    'Client' => $client,
                    'kuchis' => $kuchis,
                    'Btncache' => $hidden,
        ));
    }
    /*
     * Modification d'un abonnement
     */
    public function updateAction($id) {
        $Logger = $this->container->get('obdo_services.Logger');
        
        $abonnement = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Abonnements')
                ->find($id);
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($abonnement->getClient());
        
        $form = $this->createForm(new AbonnementsType, $abonnement);
        
        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
                $Logger->Info("[Abonnement] [user : " . $this->get('security.context')
                        ->getToken()->getUser()->getUserName() . "] " . $abonnement->getTitreabo() . " updated");
                
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_abo_view', array(
                                    'id' => $id,
                )));
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:abonnementsadd.html.twig', array(
                        'form' => $form->createView(),
                        'action' => 'Modifier',
                        'client' => $client,
            ));
    }
    /*
     * Affectation d'un kuchi à un abonnement
     */
    public function kuchiAction($id){
        $Logger = $this->container->get('obdo_services.Logger');
        
        $abonnement = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Abonnements')
                ->find($id);
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($abonnement->getClient());
        
        // on récupére l'id de l'utilisateur courant
        $userid = $this->get('security.context')->getToken()->getUser()->getId();
        $a = array();
        // on genere le formulaire liste des kuchis que l'utilisateur à le droit de voir
        $formulaire = $this->createFormBuilder($a)
                        ->add('kuchis', 'entity', array(
                                'class'    => 'obdoKuchiKomiRESTBundle:Kuchi',
                                'property' => 'name',
                                'multiple' => true ,
                                'required' => false,
                                'query_builder' => function(KuchiRepository $r)
                                use($userid) {
                                return $r->getKuchisByUserId($userid);
                                }));
        $form = $formulaire->getForm();
        // On récupère la requête
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                 if ($form['kuchis']->getData() != null) {
                        foreach ($form['kuchis']->getData() as $k) {
                            $k->setAbonnement($abonnement->getId());
                            
                            $Logger->Info("[Abonnement] [user : " . $this->get('security.context')
                            ->getToken()->getUser()->getUserName() . "] " 
                            . $abonnement->getTitreabo() . " [kuchi] ".$k->getName()." added");
                        }
                        $em = $this->getDoctrine()->getManager();
                        $em->flush();
                    }
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_abo_view', array(
                                        'id' => $id,
                    )));
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:abonnementskuchi.html.twig', array(
                         'form' => $form->createView(),
                         'action' => 'Ajout Kuchi',
                         'abonnement' => $abonnement,
                         'client' => $client,
             )); 
    }
    /*
     * Retire un kuchi de l'abonnement
     */
    public function kuchiremoveAction($id, $aboid){
        $Logger = $this->container->get('obdo_services.Logger');
        
        $kuchi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->find($id);
        
        //uniquement la pour le log
        $abonnement = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Abonnements')
                ->find($aboid);
        
        // si on à trouvé le kuchi
        if ($kuchi){
            $kuchi->setAbonnement(null);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $Logger->Info("[Abonnement] [user : " . $this->get('security.context')
                            ->getToken()->getUser()->getUserName() . "] " 
                            . $abonnement->getTitreabo() . " [kuchi] ".$kuchi->getName()." removed");
        }
        // et on réaffiche l'abonnement
        return $this->redirect($this->generateUrl('obdo_kuchi_komi_abo_view', array(
                                        'id' => $aboid,
                    )));
        
    }
    /*
     * Determine si le bouton d'affectation d'un kuchi à l'abonnement s'affiche
     * en fonction du maxkuchi de l'abonnement
     */
    public function btnafficheAddKushi($abonnement) {
        $hidden = false;
       
        // combien de kuchis autorisés
        $maxkuchi = $abonnement->getNbMaxKuchi();
        // combien de kuchis actifs pour ce groupe
        $countkuchi = $this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:Kuchi')
                    ->getNbKuchiAbo($abonnement->getId());
        if ($countkuchi >= $maxkuchi)
            $hidden = true;
        return $hidden;
    }
}
