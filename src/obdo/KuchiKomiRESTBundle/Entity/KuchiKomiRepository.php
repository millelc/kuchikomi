<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * KuchiKomiRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KuchiKomiRepository extends EntityRepository
{
    public function getNbKuchiKomi()
    {
        return $this->createQueryBuilder('kuchikomi')
                    ->select('COUNT(kuchikomi)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    public function getAddedKuchiKomis( $komi )
    {
    	$qb = $this->createQueryBuilder('kuchikomi')
    	->leftJoin('kuchikomi.kuchi', 'kuchi')
    	->addSelect('kuchi')
       	->join('kuchi.subscriptions', 'subscriptions', 'WITH', 'subscriptions.komi = :komi AND subscriptions.active = true')
    	->addSelect('subscriptions')
    	->setParameter('komi', $komi)
    	->Where('kuchikomi.active = true AND kuchikomi.timestampCreation >= :fromDate')
    	->orWhere('kuchikomi.active = true AND kuchikomi.timestampCreation < :fromDate AND :fromDate < subscriptions.timestampLastUpdate ')
    	->setParameter('fromDate', $komi->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    

    public function getAddedKuchiKomisForKuchi( $kuchiAccount )
    {
    	$qb = $this->createQueryBuilder('kuchikomi')
    	->leftJoin('kuchikomi.kuchi', 'kuchi')
    	->addSelect('kuchi')
    	->Where('kuchi = :kuchi')
    	->setParameter('kuchi', $kuchiAccount->getKuchi() )
    	->andWhere('kuchikomi.active = true AND kuchikomi.timestampCreation >= :fromDate')
    	->setParameter('fromDate', $kuchiAccount->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    
    public function getUpdatedKuchiKomis( $komi )
    {
    	$qb = $this->createQueryBuilder('kuchikomi')
    	->leftJoin('kuchikomi.kuchi', 'kuchi')
    	->addSelect('kuchi')
    	->join('kuchi.subscriptions', 'subscriptions', 'WITH', 'subscriptions.komi = :komi AND subscriptions.active = true')
    	->addSelect('subscriptions')
    	->setParameter('komi', $komi)
    	->Where('kuchikomi.active = true AND kuchikomi.timestampCreation < :fromDate AND kuchikomi.timestampLastUpdate >= :fromDate')
    	->setParameter('fromDate', $komi->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    
    public function getUpdatedKuchiKomisForKuchi( $kuchiAccount )
    {
    	$qb = $this->createQueryBuilder('kuchikomi')
    	->leftJoin('kuchikomi.kuchi', 'kuchi')
    	->addSelect('kuchi')
    	->Where('kuchi = :kuchi')
    	->setParameter('kuchi', $kuchiAccount->getKuchi() )
    	->andWhere('kuchikomi.active = true AND kuchikomi.timestampCreation < :fromDate AND kuchikomi.timestampLastUpdate >= :fromDate')
    	->setParameter('fromDate', $kuchiAccount->getTimestampLastSynchro() );

    	return $qb->getQuery()->getResult();
    }
    
    public function getDeletedKuchiKomis( $komi )
    {
    	$qb = $this->createQueryBuilder('kuchikomi')
    	->leftJoin('kuchikomi.kuchi', 'kuchi')
    	->addSelect('kuchi')
    	->join('kuchi.subscriptions', 'subscriptions', 'WITH', 'subscriptions.komi = :komi AND subscriptions.active = true')
    	->addSelect('subscriptions')
    	->setParameter('komi', $komi)
    	->Where('kuchikomi.active = false AND kuchikomi.timestampSuppression >= :fromDate')
    	->setParameter('fromDate', $komi->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    
    public function getDeletedKuchiKomisForKuchi( $kuchiAccount )
    {
    	$qb = $this->createQueryBuilder('kuchikomi')
    	->leftJoin('kuchikomi.kuchi', 'kuchi')
    	->addSelect('kuchi')
    	->Where('kuchi = :kuchi')
    	->setParameter('kuchi', $kuchiAccount->getKuchi())
    	->andWhere('kuchikomi.active = false AND kuchikomi.timestampSuppression >= :fromDate')
    	->setParameter('fromDate', $kuchiAccount->getTimestampLastSynchro() );
    
    	return $qb->getQuery()->getResult();
    }
    
    public function getNbKuchiKomiByUserId($userid)
    {
        return $this->createQueryBuilder('kuchikomi')
                    ->select('COUNT(kuchikomi)')
                    ->leftjoin('kuchikomi.kuchi','kuchi')
                    ->leftjoin('kuchi.kuchiGroup','kuchiGroup')
                    ->join('kuchiGroup.users', 'users')
                    ->where('users.id = :userid')
                    ->setParameter('userid', $userid)
                    ->getQuery()
                    ->getSingleScalarResult(); 
    }
}
