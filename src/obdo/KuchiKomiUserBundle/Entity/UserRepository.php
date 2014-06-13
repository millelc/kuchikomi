<?php

namespace obdo\KuchiKomiUserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
	public function getUsers($nombreParPage, $page, $sort)
	{
		// On déplace la vérification du numéro de page dans cette méthode
		if ($page < 1)
		{
			throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
		}
	
		// La construction de la requête reste inchangée
		$query = $this->createQueryBuilder('users');
	
		if( $sort == "name_up" )
		{
			$query->orderBy('users.username','DESC');
		}
		elseif( $sort == "name_down" )
		{
			$query->orderBy('users.username','ASC');
		}
		elseif( $sort == "role_up" )
		{
			$query->orderBy('users.roles','ASC');
		}
		elseif( $sort == "role_down" )
		{
			$query->orderBy('users.roles','DESC');
		}
	
		$query->getquery();
		// On définit l'article à partir duquel commencer la liste
		$query->setFirstResult(($page-1) * $nombreParPage)
		// Ainsi que le nombre d'articles à afficher
		->setMaxResults($nombreParPage);
	
		return new Paginator($query);
	}
        
        public function getUsersForForm(){
            $qb = $this->createQueryBuilder('users');
            return $qb;
        }
	
}
