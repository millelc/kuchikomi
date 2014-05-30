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

class KuchiKomiController extends Controller {

    /**
     * @Post("/rest/kuchikomi/{id_komi}/{id_kuchi}/{hash}")
     * @return array
     * @View()
     */
    public function postKuchiKomiAction($id_komi, $id_kuchi, $hash) {
        $response = new Response();

        $Logger = $this->container->get('obdo_services.Logger');

        $em = $this->getDoctrine()->getManager();

        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');

        $kuchi = $repositoryKuchi->findOneById($id_kuchi);
        if (!$kuchi) {
            // kuchi unknown !
            $response->setStatusCode(502);
            $Logger->Error("[POST rest/kuchikomi] 502 - Invalid Kuchi id");
        } else {
            $komi = $repositoryKomi->findOneByRandomId($id_komi);

            if (!$komi) {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[POST rest/kuchikomi] 501 - Komi id=" . $id_komi . " unknown");
            } else {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));

                if (!$kuchiAccount) {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[POST rest/kuchikomi] 504 - Kuchi admin account unknown");
                } else {
                    if ($hash == sha1("POST /rest/kuchikomi" . $kuchiAccount->getToken())) {
                        $json = $this->getRequest()->getContent();
                        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('kuchikomi' => new JsonEncoder()));
                        $kuchikomiArray = $serializer->decode($json, 'json');
                        
                        
                        //on cherche le randomid
                        $kuchikomi = $repositoryKuchiKomi->findOneByRandomId($kuchikomiArray['kuchikomi']['random_id']);
                        if (!$kuchikomi){
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

                            if ($kuchikomiArray['kuchikomi']['photo'] != "") {
                                $photoName = $this->container->get('obdo_services.Name_photo')->newName();
                                $kuchikomi->setPhotoLink($kuchi->getPhotoKuchiKomiLink() . $photoName);

                                $photoByteStream = base64_decode($kuchikomiArray['kuchikomi']['photo']);

                                $path = $this->get('kernel')->getRootDir() . "/../web/" . $kuchikomi->getPhotoLink();
                                $Logger->Info($path);

                                $fp = fopen($path, 'xb');

                                if (!$fp) {
                                    $Logger->Error(error_get_last());
                                } else {
                                    fwrite($fp, $photoByteStream);
                                    fclose($fp);
                                }
                            }

                            $em->persist($kuchikomi);
                            $em->flush();
                        
                            $this->sendKuchiKomiNotification($kuchi, $kuchikomi, "2");
                        }    
                        $response->setStatusCode(200);
                        $Logger->Info("[POST rest/kuchikomi] 200 - kuchikomi");
                    } else {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[POST rest/kuchikomi] 510 - hash invalide");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }


        $response->headers->set('Content-Type', 'text/html');
        $response->setContent("");
        $response->send();

        return $response;
    }

    /**
     * Set a new notification to all Komi suscribers
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi
     * @return Kuchi
     */
    private function sendKuchiKomiNotification(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi, \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi, $type) {
        $em = $this->getDoctrine()->getManager();
        $Notifier = $this->container->get('obdo_services.Notifier');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');


        $subscriptions = $kuchi->getSubscriptions();
        foreach ($subscriptions as $subscription) {
            if ($subscription->getActive()) {
                $komi = $subscription->getKomi();
                $Notifier->sendMessage($komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => $type));
            }
        }

        $kuchiAccounts = $repositoryKuchiAccount->getKuchiAccountForKuchi($kuchi);
        foreach ($kuchiAccounts as $kuchiAccount) {
            $komi = $kuchiAccount->getKomi();
            $Notifier->sendMessage($komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => "4"));
        }
    }

    /**
     * @Delete("/rest/kuchikomi/{komiId}/{id_kuchi}/{id_kuchikomi}/{hash}")
     * @return array
     * @View()
     */
    public function deleteKuchiKomiAction($komiId, $id_kuchi, $id_kuchikomi, $hash) {
        $response = new Response();

        $Logger = $this->container->get('obdo_services.Logger');
        $em = $this->getDoctrine()->getManager();

        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');

        $kuchi = $repositoryKuchi->findOneById($id_kuchi);

        if (!$kuchi) {
            // kuchi unknown !
            $Logger->Info("[DELETE rest/kuchikomi/{komi}/{id_kuchi}/{id_kuchikomi}/{hash}] 502 - Kuchi id=" . $id_kuchi . " unknown...");
            $response->setStatusCode(502);
        } else {
            $komi = $repositoryKomi->findOneByRandomId($komiId);

            if (!$komi) {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[DELETE rest/kuchikomi/{komi}/{id_kuchi}/{id_kuchikomi}/{hash}] 501 - Komi id=" . $komiId . " unknown");
            } else {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));

                if (!$kuchiAccount) {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[DELETE rest/kuchikomi/{komi}/{id_kuchi}/{id_kuchikomi}/{hash}] 504 - Kuchi admin account unknown");
                } else {

                    if ($hash == sha1("DELETE /rest/kuchikomi" . $kuchiAccount->getToken())) {
                        $kuchikomi = $repositoryKuchiKomi->findOneById($id_kuchikomi);

                        if (!$kuchikomi) {
                            // kuchikomi unknown
                            $response->setStatusCode(503);
                            $Logger->Info("[DELETE rest/kuchikomi/{komi}/{id_kuchi}/{id_kuchikomi}/{hash}] 503 - KuchiKomi id=" . $id_kuchikomi . " unknown...");
                        } else {
                            $kuchikomi->setTimestampSuppression(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
                            $kuchikomi->setActive(false);

                            $em->flush();

                            $this->sendKuchiKomiNotification($kuchi, $kuchikomi, "3");

                            $response->setStatusCode(200);
                            $Logger->Info("[DELETE rest/kuchikomi/{komi}/{id_kuchi}/{id_kuchikomi}/{hash}] 200 - KuchiKomi id=" . $kuchikomi->getId() . " deleted");
                        }
                    } else {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[DELETE rest/kuchikomi/{komi}/{id_kuchi}/{id_kuchikomi}/{hash}] 600 - Invalid hash");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();

        return $response;
    }

}
