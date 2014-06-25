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
    
    public static function getNbKuchikomiHeure($context)
    {
        $requete = 'SELECT count( * ) as nbre , hour( time( timestampCreation ) ) as heure
                    FROM KuchiKomi
                    WHERE TO_DAYS( NOW( ) ) - TO_DAYS( timestampCreation ) =1
                    GROUP BY hour( time( timestampCreation ) ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function getNbKomiHeure($context)
    {
        $requete = 'SELECT count( * ) as nbre , hour( time( timestampCreation ) ) as heure
                    FROM Komi
                    WHERE TO_DAYS( NOW( ) ) - TO_DAYS( timestampCreation ) =1
                    GROUP BY hour( time( timestampCreation ) ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute();
        return $query->fetchAll();
    }
    /*
     * getMaxDetailKuchiKomi
     * retourne le message ayant la description max de la table avec le nom du kuchi
     */
    public static function getMaxDetailKuchiKomi($context)
    {
        $requete = 'SELECT KuchiKomi . * , length( details ) AS taillemax, Kuchi.name
                    FROM KuchiKomi, Kuchi
                    WHERE length( details ) = (
                    SELECT MAX( length( details ) )
                    FROM KuchiKomi )
                    AND KuchiKomi.kuchi_id = Kuchi.id ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute();
        return $query->fetchAll();
    }
     /*
     * getAvgDetailKuchiKomi
     * retourne la taille moyenne de la description
     */
    public static function getAvgDetailKuchiKomi($context)
    {
        $requete = 'SELECT 1 , avg(  IFNULL( length( details ) , 0 ) ) AS moyenne
                    FROM KuchiKomi
                    GROUP BY 1  ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute();
        return $query->fetchAll();
    }
    /*
     * Retourne le nbre de caracteres / jour du mois
     */
    public static function getNbDetailMois($mois,$an, $context)
    {
        $requete = 'SELECT day( date( k.timestampCreation ) ) AS jour, sum( IFNULL( length( details ) , 0 ) ) AS nbre
                    FROM KuchiKomi k
                    WHERE month( date( k.timestampCreation ) ) = :mois
                    AND year( date( k.timestampCreation ) ) = :an
                    GROUP BY day( date( k.timestampCreation ) ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
        return $query->fetchAll();
    }
    
    public static function getNbKuchiKomiByClientId($clientid, $context)
    {
        $requete = 'SELECT count( * ) as nbkuchikomi
                        FROM KuchiKomi AS kk
                        JOIN Kuchi AS k ON kk.kuchi_id = k.id
                        JOIN Abonnements AS a ON k.abonnement = a.id
                        JOIN Clients AS c ON a.client = c.id
                        WHERE c.id = :client ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('client' => $clientid));
        return $query->fetchAll();
        
    }
    /*
     * getAvgDetailClient
     * retourne la taille moyenne de la description pour le client $clientid
     */
    public static function getAvgDetailClient($clientid,$context)
    {
        $requete = 'SELECT 1 , avg(  IFNULL( length( details ) , 0 ) ) AS moyenne
                    FROM KuchiKomi AS kk
                        JOIN Kuchi AS k ON kk.kuchi_id = k.id
                        JOIN Abonnements AS a ON k.abonnement = a.id
                        JOIN Clients AS c ON a.client = c.id
                        WHERE c.id = :client 
                    GROUP BY 1  ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('client' => $clientid));
        return $query->fetchAll();
    }
    
    /*
     * Retourne le nbre de kuchikomis/mois sur un an glissant du client $clientid
     */
    public static function getNbKuchiKomisAnClient($gt,$lt,$clientid, $context)
    {
        $requete = 'SELECT (year( date( kk.timestampCreation ) )) *100 + 
                    ( month( date( kk.timestampCreation ) ) ) AS anmois, count( * ) AS nbre
                    FROM KuchiKomi AS kk
                        JOIN Kuchi AS k ON kk.kuchi_id = k.id
                        JOIN Abonnements AS a ON k.abonnement = a.id
                        WHERE a.client = :client and ((year( date( kk.timestampCreation ) )
                        ) *100 + (month( date( kk.timestampCreation ) ))
                        BETWEEN :lt AND :gt )
                    GROUP BY anmois';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('lt' => intval($lt), 'gt' => intval($gt), 'client' => $clientid));
        return $query->fetchAll();
    }
    
    public static function getNbKuchikomiDate($datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( * ) as nbre , date( timestampCreation ) as jour
                    FROM KuchiKomi
                    WHERE date( timestampCreation ) BETWEEN :datedeb AND :datefin
                    GROUP BY date( timestampCreation ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin));
        return $query->fetchAll();
    }
    
    public static function getNbKomiDate($datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( * ) as nbre , date( timestampCreation ) as jour
                    FROM Komi
                    WHERE date( timestampCreation ) BETWEEN :datedeb AND :datefin
                    GROUP BY date( timestampCreation ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin));
        return $query->fetchAll();
    }
    
    public static function getAppelsDateMois($datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( * ) as nbre , date( dateappel ) as jour , SUM(temps) as ttemps
                    FROM Appels
                    WHERE date( dateappel ) BETWEEN :datedeb AND :datefin
                    GROUP BY date( dateappel ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin));
        return $query->fetchAll();
    }
    
    public static function getAppelsDateAn($datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( * ) as nbre , month(date( dateappel )) as jour , SUM(temps) as ttemps
                    FROM Appels
                    WHERE date( dateappel ) BETWEEN :datedeb AND :datefin
                    GROUP BY month(date( dateappel )) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin));
        return $query->fetchAll();
    }

    public static function getAppelsDateMoisClient($clientid,$datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( * ) as nbre , date( dateappel ) as jour , SUM(temps) as ttemps
                    FROM Appels
                    WHERE (date( dateappel ) BETWEEN :datedeb AND :datefin ) 
                    AND client_id = :clientid
                    GROUP BY date( dateappel ) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin, 'clientid' => $clientid));
        return $query->fetchAll();
    }
    
    public static function getAppelsDateAnClient($clientid,$datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( * ) as nbre , month(date( dateappel )) as jour , SUM(temps) as ttemps
                    FROM Appels
                    WHERE (date( dateappel ) BETWEEN :datedeb AND :datefin ) 
                    AND client_id = :clientid
                    GROUP BY month(date( dateappel )) ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin, 'clientid' => $clientid));
        return $query->fetchAll();
    }
    
    public static function getAppelsTypeDate($datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( a.id ) AS nbre, SUM( a.temps ) AS ttemps, t.Description AS typeappel
                    FROM Appels a, TypeAppel t
                    WHERE date( dateappel ) BETWEEN :datedeb AND :datefin
                    AND a.typeappel_id = t.id
                    GROUP BY t.id
                    ORDER BY t.Description ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin));
        return $query->fetchAll();
    }
    
    public static function getAppelsTypeDateClient($clientid,$datedeb,$datefin,$context)
    {
        $requete = 'SELECT count( a.id ) AS nbre, SUM( a.temps ) AS ttemps, t.Description AS typeappel
                    FROM Appels a, TypeAppel t
                    WHERE (date( dateappel ) BETWEEN :datedeb AND :datefin ) 
                    AND a.client_id = :clientid
                    AND a.typeappel_id = t.id
                    GROUP BY t.id
                    ORDER BY t.Description ';

        $em = $context->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = $db->prepare($requete);
        $query->execute(array('datedeb' => $datedeb, 'datefin' => $datefin, 'clientid' => $clientid));
        return $query->fetchAll();
    }
}
