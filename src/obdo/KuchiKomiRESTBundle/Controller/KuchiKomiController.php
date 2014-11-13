<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiAccount;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;

class KuchiKomiController extends Controller 
{

    /**
     * @Post("/rest/kuchikomi/{id_komi}/{id_kuchi}/{hash}")
     * @return array
     * @View()
     */
    public function postKuchiKomiAction($id_komi, $id_kuchi, $hash) 
    {
        $response = new Response();

        $Logger = $this->container->get('obdo_services.Logger');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
        
        $em = $this->getDoctrine()->getManager();

        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');

        $kuchi = $repositoryKuchi->findOneById($id_kuchi);
        if (!$kuchi) 
        {
            // kuchi unknown !
            $response->setStatusCode(502);
            $Logger->Error("[POST rest/kuchikomi] 502 - Invalid Kuchi id");
        } 
        else 
        {
            $komi = $repositoryKomi->findOneByRandomId($id_komi);

            if (!$komi) 
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[POST rest/kuchikomi] 501 - Komi id=" . $id_komi . " unknown");
            } 
            else 
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));

                if (!$kuchiAccount) 
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[POST rest/kuchikomi] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                } 
                else 
                {
                    if ($hash == sha1("POST /rest/kuchikomi" . $kuchiAccount->getToken())) 
                    {
                        $json = $this->getRequest()->getContent();
                        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('kuchikomi' => new JsonEncoder()));
                        $kuchikomiArray = $serializer->decode($json, 'json');
                        
                        $response->setStatusCode(200);
                        //on cherche le randomid
                        $kuchikomi = $repositoryKuchiKomi->findOneByRandomId($kuchikomiArray['kuchikomi']['random_id']);
                        if (!$kuchikomi)
                        {
                            
                            $kuchikomi = new KuchiKomi();
                     
                            $timestampBegin = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                            $timestampBegin->setTimestamp($kuchikomiArray['kuchikomi']['timestampBegin']);

                            $timestampEnd = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                            $timestampEnd->setTimestamp($kuchikomiArray['kuchikomi']['timestampEnd']);

                            $kuchikomi->setKuchi($kuchi);
                            $kuchikomi->setTitle(ucfirst($kuchikomiArray['kuchikomi']['title']));
                            $kuchikomi->setDetails(ucfirst($kuchikomiArray['kuchikomi']['details']));
                            $kuchikomi->setTimestampBegin($timestampBegin);
                            $kuchikomi->setTimestampEnd($timestampEnd);
                            $kuchikomi->setOrigin($komi->getOsType());
                            $kuchikomi->setRandomId($kuchikomiArray['kuchikomi']['random_id']);

                            if ($kuchikomiArray['kuchikomi']['photo'] != "") 
                            {
                                $photoName = $this->container->get('obdo_services.Name_photo')->newName();
                                $kuchikomi->setPhotoLink($kuchi->getPhotoKuchiKomiLink() . $photoName);

                                $photoByteStream = base64_decode($kuchikomiArray['kuchikomi']['photo']);

                                $path = $this->get('kernel')->getRootDir() . "/../web/" . $kuchikomi->getPhotoLink();
                                
                                $fp = fopen($path, 'xb');

                                if (!$fp) 
                                {
                                    $Logger->Error("[POST /rest/kuchikomi] Photo file open failed - Path = ".$path." - (" . error_get_last() . ")");
                                    $response->setStatusCode(511);
                                } 
                                else 
                                {
                                    fwrite($fp, $photoByteStream);
                                    fclose($fp);
                                }
                            }

                            if($response->getStatusCode() == 200 )
                            {
                                $em->persist($kuchikomi);
                                $em->flush();

                                // Add Acl for the object (SUPER_ADMIN + GROUP_ADMIN + CURRENT USER)
                                $AclManager = $this->container->get('obdo_services.AclManager');
                                foreach($kuchikomi->getKuchi()->getUsers() as $user)
                                {
                                    $AclManager->addAcl($kuchikomi, $user);
                                }
                                foreach($kuchikomi->getKuchi()->getKuchiGroup()->getUsers() as $user)
                                {
                                    $AclManager->addAcl($kuchikomi, $user);
                                }

                                $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, "2");
                            }
                        }    
                    } 
                    else 
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[POST rest/kuchikomi] 510 - Komi id=". $komi->getRandomId() . " - osType=" . $komi->getOsType() . " - hash=" . $hash . " invalid");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }

        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

    /**
     * @Delete("/rest/kuchikomi/{komiId}/{id_kuchi}/{id_kuchikomi}/{hash}")
     * @return array
     * @View()
     */
    public function deleteKuchiKomiAction($komiId, $id_kuchi, $id_kuchikomi, $hash) 
    {
        $response = new Response();

        $Logger = $this->container->get('obdo_services.Logger');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
        
        $em = $this->getDoctrine()->getManager();

        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');

        $kuchi = $repositoryKuchi->findOneById($id_kuchi);

        if (!$kuchi) 
        {
            // kuchi unknown !
            $Logger->Error("[DELETE rest/kuchikomi/] 502 - Kuchi id=" . $id_kuchi . " unknown...");
            $response->setStatusCode(502);
        } 
        else 
        {
            $komi = $repositoryKomi->findOneByRandomId($komiId);

            if (!$komi) 
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[DELETE rest/kuchikomi/] 501 - Komi id=" . $komiId . " unknown");
            } 
            else 
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));

                if (!$kuchiAccount) 
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[DELETE rest/kuchikomi/] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                } 
                else 
                {
                    if ($hash == sha1("DELETE /rest/kuchikomi" . $kuchiAccount->getToken())) 
                    {
                        $kuchikomi = $repositoryKuchiKomi->findOneById($id_kuchikomi);

                        if (!$kuchikomi) 
                        {
                            // kuchikomi unknown
                            $response->setStatusCode(503);
                            $Logger->Error("[DELETE rest/kuchikomi/] 503 - KuchiKomi id=" . $id_kuchikomi . " unknown...");
                        } 
                        else 
                        {
                            if($kuchikomi->getActive() == true)
                            {
                                $kuchikomi->setTimestampSuppression(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
                                $kuchikomi->setActive(false);

                                $em->flush();

                                $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, "3");
                            }
                            
                            $response->setStatusCode(200);
                            $Logger->Info("[DELETE rest/kuchikomi/] 200 - KuchiKomi id=" . $kuchikomi->getId() . " deleted");
                        }
                    } 
                    else 
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[DELETE rest/kuchikomi/] 510 - Invalid hash");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }

    /**
     * @Put("/rest/kuchikomi/{komiId}/{id_kuchi}/{id_kuchikomi}/{hash}")
     * @return array
     * @View()
     */
    public function putKuchiKomiAction($komiId, $id_kuchi, $id_kuchikomi, $hash) 
    {
        $response = new Response();

        $Logger = $this->container->get('obdo_services.Logger');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
        //$Notifier = $this->container->get('obdo_services.Notifier');
        
        $em = $this->getDoctrine()->getManager();

        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');

        $kuchi = $repositoryKuchi->findOneById($id_kuchi);

        if (!$kuchi) 
        {
            // kuchi unknown !
            $Logger->Error("[PUT rest/kuchikomi/] 502 - Kuchi id=" . $id_kuchi . " unknown...");
            $response->setStatusCode(502);
        } 
        else 
        {
            $komi = $repositoryKomi->findOneByRandomId($komiId);

            if (!$komi) 
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[PUT rest/kuchikomi/] 501 - Komi id=" . $komiId . " unknown");
            } 
            else 
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));

                if (!$kuchiAccount) 
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[PUT rest/kuchikomi/] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                } 
                else 
                {
                    if (true)//$hash == sha1("PUT /rest/kuchikomi" . $kuchiAccount->getToken())) 
                    {
                        $kuchikomi = $repositoryKuchiKomi->findOneById($id_kuchikomi);

                        if (!$kuchikomi) 
                        {
                            // kuchikomi unknown
                            $response->setStatusCode(503);
                            $Logger->Error("[PUT rest/kuchikomi/] 503 - KuchiKomi id=" . $id_kuchikomi . " unknown...");
                        } 
                        else 
                        {
                            $response->setStatusCode(200);
                            
                            $json = $this->getRequest()->getContent();
                            $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('kuchikomi' => new JsonEncoder()));
                            $kuchikomiArray = $serializer->decode($json, 'json');

                            $timestampBegin = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                            $timestampBegin->setTimestamp($kuchikomiArray['kuchikomi']['timestampBegin']);

                            $timestampEnd = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                            $timestampEnd->setTimestamp($kuchikomiArray['kuchikomi']['timestampEnd']);

                            $kuchikomi->setTitle(ucfirst($kuchikomiArray['kuchikomi']['title']));
                            $kuchikomi->setDetails(ucfirst($kuchikomiArray['kuchikomi']['details']));
                            $kuchikomi->setTimestampBegin($timestampBegin);
                            $kuchikomi->setTimestampEnd($timestampEnd);
                            $kuchikomi->setOrigin($komi->getOsType());
                            
                            if ($kuchikomiArray['kuchikomi']['photo'] != "") 
                            {
                                // Update the photo
                                $photoName = $this->container->get('obdo_services.Name_photo')->newName();
                                if($kuchikomi->getPhotoLink() != "")
                                {
                                    unlink($kuchikomi->getPhotoLink());
                                }
                                $kuchikomi->setPhotoLink($kuchi->getPhotoKuchiKomiLink() . $photoName);

                                $photoByteStream = base64_decode($kuchikomiArray['kuchikomi']['photo']);

                                $path = $this->get('kernel')->getRootDir() . "/../web/" . $kuchikomi->getPhotoLink();
                                
                                $fp = fopen($path, 'xb');

                                if (!$fp) 
                                {
                                    $Logger->Error("[POST /rest/kuchikomi] Photo file open failed - Path = ".$path." - (" . error_get_last() . ")");
                                    $response->setStatusCode(511);
                                } 
                                else 
                                {
                                    fwrite($fp, $photoByteStream);
                                    fclose($fp);
                                }
                            }
                            else
                            {
                                // Erase the photo
                                if($kuchikomi->getPhotoLink() != "")
                                {
                                    unlink($kuchikomi->getPhotoLink());
                                }
                                $kuchikomi->resetPhotoLink();
                            }

                            if( $response->getStatusCode() == 200 )
                            {
                                $em->persist($kuchikomi);
                                $em->flush();

                                $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, "2");

                                $Logger->Info("[PUT rest/kuchikomi/] 200 - KuchiKomi id=" . $kuchikomi->getId() . " updated");                                
                            }

                        }
                    } 
                    else 
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[PUT rest/kuchikomi/] 510 - Invalid hash");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        
        return $response;
    }

}
