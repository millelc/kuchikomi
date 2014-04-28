<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SubscriptionGroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubscriptionGroupRepository extends EntityRepository
{
    /**
     * Get the number of subscription active
     *
     */
    public function getNbSubGrpKomiActive($komi)
    {
    	
    	$qb = $this->createQueryBuilder('subscription')
    	->select('COUNT(subscription.komi)')
    	->andWhere('subscription.komi = :komi')
    	->setParameter('komi', $komi)
    	->andWhere('subscription.active = 1');
    	 
    	return $qb->getQuery()->getSingleScalarResult();
    }
}
