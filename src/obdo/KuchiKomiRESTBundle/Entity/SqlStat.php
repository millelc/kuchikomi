<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

/**
 * Description of SqlStat
 *
 * Requete SQL natives pour les stats
 * 
 * @author frederic
 */

class SqlStat {
     public static function getNbKuchiMois($mois,$an, $context)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Kuchi k where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
        return $query->fetchAll();
    }
    
    public static function getNbKomiMois($mois,$an, $context)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Komi k where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
        return $query->fetchAll();
    }
    
    public static function getNbSubscriptionMois($mois,$an, $context)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Subscription k where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
        return $query->fetchAll();
    }
    
    public static function getNbKuchikomiMois($mois,$an, $context)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from KuchiKomi k where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
        return $query->fetchAll();
    }
    
    public static function getNbThanksMois($mois,$an, $context)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Thanks k where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
        return $query->fetchAll();
    }
}
