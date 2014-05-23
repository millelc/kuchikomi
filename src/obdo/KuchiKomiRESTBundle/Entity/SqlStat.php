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
     public static function getNbKuchiMois($mois,$an, $context, $userid)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Kuchi k join KuchiGroup kg on k.kuchiGroup_id = kg.id ';
        $requete = $requete . 'join user_kuchigroup ukg on kg.id = ukg.kuchigroup_id ';
        $requete = $requete . 'where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' AND ukg.user_id = :userid';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an), 'userid' => intval($userid)));
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
    
    public static function getNbSubscriptionMois($mois,$an, $context, $userid)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Subscription k join Kuchi kc on k.kuchi_id = kc.id ';
        $requete = $requete . 'join KuchiGroup kg on kc.kuchiGroup_id = kg.id ';
        $requete = $requete . 'join user_kuchigroup ukg on kg.id = ukg.kuchigroup_id ';
        $requete = $requete . 'where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' AND ukg.user_id = :userid';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an), 'userid' => intval($userid)));
        return $query->fetchAll();
    }
    
    public static function getNbKuchikomiMois($mois,$an, $context, $userid)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from KuchiKomi k join Kuchi kc on k.kuchi_id = kc.id ';
        $requete = $requete . 'join KuchiGroup kg on kc.kuchiGroup_id = kg.id ';
        $requete = $requete . 'join user_kuchigroup ukg on kg.id = ukg.kuchigroup_id ';
        $requete = $requete . 'where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' AND ukg.user_id = :userid';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an), 'userid' => intval($userid)));
        return $query->fetchAll();
    }
    
    public static function getNbThanksMois($mois,$an, $context, $userid)
    {
        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
        $requete = $requete . 'from Thanks k join KuchiKomi kk on k.kuchikomi_id = kk.id ';
        $requete = $requete . 'join Kuchi kc on kk.kuchi_id = kc.id ';
        $requete = $requete . 'join KuchiGroup kg on kc.kuchiGroup_id = kg.id ';
        $requete = $requete . 'join user_kuchigroup ukg on kg.id = ukg.kuchigroup_id ';
        $requete = $requete . 'where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
        $requete = $requete . ' AND ukg.user_id = :userid';
        $requete = $requete . ' group by day( date( k.timestampCreation ))';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an), 'userid' => intval($userid)));
        return $query->fetchAll();
    }
}
