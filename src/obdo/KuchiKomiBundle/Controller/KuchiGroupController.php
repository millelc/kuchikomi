<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KuchiGroupController extends Controller
{
    public function indexAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        
        $groups = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')->getGroups(25, $page, $sort);
        
        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupindex.html.twig', array(
                                                                                        'groups'   => $groups,
                                                                                        'page'   => $page,
                                                                                        'nombrePage' => ceil(count($groups)/25),
                                                                                        'sort'   => $sort
                                                                                        ));
    }
    
    public function viewAction($id)
    {
        $kuchiGroup = $this->getDoctrine()
                           ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                           ->find($id);
                
        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                                                                                        'KuchiGroup' => $kuchiGroup,
                                                                                        ));        
    }
    
    public function addAction()
    {
        $kuchiGroup = new KuchiGroup();

        $formBuilder = $this->createFormBuilder($kuchiGroup);
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
                $em->persist($kuchiGroup);
                $em->flush();
                
                $Logger->Info("[KuchiGroup] [user : ".$this->get('security.context')->getToken()->getUser()->getUserName()."] ".$kuchiGroup->getName()." added");

                return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_group_view', array(
                                                                                                    'id' => $kuchiGroup->getId()
                                                                                                    )));
            }
        }

        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupadd.html.twig', array(
                                                                                        'form' => $form->createView(),
                                                                                        ));
    }
    
}
