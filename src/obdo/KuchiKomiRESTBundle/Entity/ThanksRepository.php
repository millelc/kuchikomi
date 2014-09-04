<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ThanksRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ThanksRepository extends EntityRepository
{
    public function getNbThanks()
    {
        return $this->createQueryBuilder('thanks')
                    ->select('COUNT(thanks)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function getNbThanksByUserId($userid)
    {
        return $this->createQueryBuilder('thanks')
                    ->select('COUNT(thanks)')
                    ->leftjoin('thanks.kuchikomi','kuchikomi')
                    ->leftjoin('kuchikomi.kuchi','kuchi')
                    ->join('kuchi.users', 'users')
                    ->where('users.id = :userid')
                    ->setParameter('userid', $userid)
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
