<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KuchiController extends Controller
{
    public function indexAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        
        $kuchis = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi')->getKuchis(25, $page, $sort);
        
        return $this->render('obdoKuchiKomiBundle:Default:kuchiindex.html.twig', array(
                                                                                        'kuchis'   => $kuchis,
                                                                                        'page'   => $page,
                                                                                        'nombrePage' => ceil(count($kuchis)/25),
                                                                                        'sort'   => $sort
                                                                                        ));
    }
    
    public function addAction($groupId)
    {
        $kuchi = new Kuchi();
        $kuchi->setKuchiGroup($this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')->find($groupId));

        $formBuilder = $this->createFormBuilder($kuchi);
        $Logger = $this->container->get('obdo_services.Logger');

        $formBuilder
            ->add('name',        'text');
            
        $form = $formBuilder->getForm();
        
        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kuchi);
                $em->flush();
                
                $Logger->Info("[Kuchi] [user : ".$this->get('security.context')->getToken()->getUser()->getUserName()."] ".$kuchi->getName()." added");

                return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_view', array(
                                                                                                    'id' => $kuchi->getId()
                                                                                                    )));
            }
        }

        return $this->render('obdoKuchiKomiBundle:Default:kuchiadd.html.twig', array(
                                                                                        'form' => $form->createView(),
                                                                                        ));
    }
    
    public function viewAction($id)
    {
        $kuchi = $this->getDoctrine()
                           ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                           ->find($id);
                
        return $this->render('obdoKuchiKomiBundle:Default:kuchiview.html.twig', array(
                                                                                        'Kuchi' => $kuchi,
                                                                                        ));        
    }
    
    
}
