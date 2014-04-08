<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use obdo\KuchiKomiRESTBundle\obdoKuchiKomiRESTBundle;

/**
 * KuchiGroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KuchiGroupRepository extends EntityRepository
{
    public function getNbGroup()
    {
        return $this->createQueryBuilder('groups')
                    ->select('COUNT(groups)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function getGroups($nombreParPage, $page, $sort)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1)
        {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('groups');

        if( $sort == "active_up")
        {
            $query->orderBy('groups.active','DESC');
        }
        elseif( $sort == "active_down" )
        {
            $query->orderBy('groups.active','ASC');
        }
        elseif( $sort == "name_up" )
        {
            $query->orderBy('groups.name','DESC');
        }
        elseif( $sort == "name_down" )
        {
            $query->orderBy('groups.name','ASC');
        }
        elseif( $sort == "creation_up" )
        {
            $query->orderBy('groups.timestampCreation','ASC');
        }
        elseif( $sort == "creation_down" )
        {
            $query->orderBy('groups.timestampCreation','DESC');
        }
        elseif( $sort == "suppression_up" )
        {
            $query->orderBy('groups.timestampSuppression','ASC');
        }
        elseif( $sort == "suppression_down" )
        {
            $query->orderBy('groups.timestampSuppression','DESC');
        }
        
        $query->getquery();
        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page-1) * $nombreParPage)
                // Ainsi que le nombre d'articles à afficher
                ->setMaxResults($nombreParPage);

        return new Paginator($query);
    }
    
    public function getAddedGroups( $komi )
    {
    	$qb = $this->createQueryBuilder('kuchigroup')
    	->leftJoin('kuchigroup.kuchis', 'kuchis')
    	->addSelect('kuchis')
    	->join('kuchis.subscriptions', 'subscriptions', 'WITH', 'subscriptions.komi = :komi')
    	->addSelect('subscriptions')
    	->setParameter('komi', $komi)
    	->Where('kuchigroup.active = true')
    	->andWhere('subscriptions.active = true AND kuchigroup.timestampCreation >= :fromDate')
    	->orWhere('subscriptions.active = true AND kuchigroup.timestampCreation < :fromDate AND :fromDate < subscriptions.timestampLastUpdate ')
    	->setParameter('fromDate', $komi->getTimestampLastSynchro() );
    	
    	return $qb->getQuery()->getResult();
    }
    
    public function getUpdatedGroups( $komi )
    {
    	$qb = $this->createQueryBuilder('kuchigroup')
    	->leftJoin('kuchigroup.kuchis', 'kuchis')
    	->addSelect('kuchis')
    	->join('kuchis.subscriptions', 'subscriptions', 'WITH', 'subscriptions.komi = :komi')
    	->addSelect('subscriptions')
    	->setParameter('komi', $komi)
    	->andWhere('kuchigroup.active =true')
    	->andWhere('kuchigroup.timestampCreation < :fromDate')
    	->andWhere('kuchigroup.timestampLastUpdate >= :fromDate')
    	->setParameter('fromDate', $komi->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    
    public function getDeletedGroups( $komi )
    {
    	$qb = $this->createQueryBuilder('kuchigroup')
    	->leftJoin('kuchigroup.kuchis', 'kuchis')
    	->addSelect('kuchis')
    	->join('kuchis.subscriptions', 'subscriptions', 'WITH', 'subscriptions.komi = :komi')
    	->addSelect('subscriptions')
    	->setParameter('komi', $komi)
    	->Where('kuchigroup.active = false AND kuchigroup.timestampSuppression >= :fromDate')
    	->setParameter('fromDate', $komi->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    
}
