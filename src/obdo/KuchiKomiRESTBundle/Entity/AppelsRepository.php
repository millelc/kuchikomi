<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AppelsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AppelsRepository extends EntityRepository
{
     public function getAppelsList($nombreParPage, $page, $sort)
    {
        // On déplace la vérification du numéro de page dans cette méthode
        if ($page < 1)
        {
            throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
        }

        
        $query = $this->createQueryBuilder('appels')
                ->leftJoin('appels.client', 'c')
                ->addSelect('c')
                ->leftjoin('appels.typeappel', 't')
                ->addSelect('t')
                ;

        if( $sort == "date_up" )
        {
            $query->orderBy('appels.dateappel','DESC');
        }
        elseif( $sort == "date_down" )
        {
            $query->orderBy('appels.dateappel','ASC');
        }
        
        $query->getquery();
        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page-1) * $nombreParPage)
                // Ainsi que le nombre d'articles à afficher
                ->setMaxResults($nombreParPage)
                ;

        return new Paginator($query);
    }
    
    public function getNbAppels()
    {
        return $this->createQueryBuilder('appels')
                    ->select('COUNT(appels)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function getTempsTotal()
    {
        return $this->createQueryBuilder('appels')
                    ->select('SUM(appels.temps)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
