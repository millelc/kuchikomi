<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * KomiRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KomiRepository extends EntityRepository
{
    public function getNbKomi()
    {
        return $this->createQueryBuilder('komi')
                    ->select('COUNT(komi)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function getKomis($nombreParPage, $page, $sort)
    {
    	// On déplace la vérification du numéro de page dans cette méthode
    	if ($page < 1)
    	{
    		throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
    	}
    
    	// La construction de la requête reste inchangée
    	$query = $this->createQueryBuilder('komis');
    
    	if( $sort == "active_up")
    	{
    		$query->orderBy('komis.active','DESC');
    	}
    	elseif( $sort == "active_down" )
    	{
    		$query->orderBy('komis.active','ASC');
    	}
    	elseif( $sort == "creation_up" )
    	{
    		$query->orderBy('komis.timestampCreation','ASC');
    	}
    	elseif( $sort == "creation_down" )
    	{
    		$query->orderBy('komis.timestampCreation','DESC');
    	}
    	elseif( $sort == "suppression_up" )
    	{
    		$query->orderBy('komis.timestampSuppression','ASC');
    	}
    	elseif( $sort == "suppression_down" )
    	{
    		$query->orderBy('komis.timestampSuppression','DESC');
    	}
    
    	$query->getquery();
    	// On définit l'article à partir duquel commencer la liste
    	$query->setFirstResult(($page-1) * $nombreParPage)
    	// Ainsi que le nombre d'articles à afficher
    	->setMaxResults($nombreParPage);
    
    	return new Paginator($query);
    }
    
}
