<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ClientsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientsRepository extends EntityRepository
{
    public function getNbClients()
    {
        return $this->createQueryBuilder('clients')
                    ->select('COUNT(clients)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function getClientsList($nombreParPage, $page, $sort)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1)
        {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
        }

        // La construction de la requête reste inchangée
        $query = $this->createQueryBuilder('clients');

        if( $sort == "name_up" )
        {
            $query->orderBy('clients.raissoc','DESC');
        }
        elseif( $sort == "name_down" )
        {
            $query->orderBy('clients.raissoc','ASC');
        }
        elseif( $sort == "creation_up" )
        {
            $query->orderBy('clients.timestampCreation','ASC');
        }
        elseif( $sort == "creation_down" )
        {
            $query->orderBy('clients.timestampCreation','DESC');
        }
        
        $query->getquery();
        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page-1) * $nombreParPage)
                // Ainsi que le nombre d'articles à afficher
                ->setMaxResults($nombreParPage);

        return new Paginator($query);
    }
    
}
