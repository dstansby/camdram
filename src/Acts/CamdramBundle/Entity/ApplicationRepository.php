<?php

namespace Acts\CamdramBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\Query\Expr;

/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends EntityRepository
{    
    /**
     * findScheduledOrderedByDeadline
     *
     * Find all applications between two dates that should be shown on the
     * diary page.
     *
     * @param integer $startDate start date expressed as a Unix timestamp
     * @param integer $endDate emd date expressed as a Unix timestamp
     *
     * @return array of applications
     */
    public function findScheduledOrderedByDeadline($startDate, $endDate)
    {
        $query_res = $this->getEntityManager()->getRepository('ActsCamdramBundle:Application');
        $query = $query_res->createQueryBuilder('a')
            ->where('a.deadline_date <= :enddate')
            ->andWhere('a.deadline_date >= :startdate')
            ->andWhere('a.deadline_date >= CURRENT_DATE()')
            ->setParameters(array(
                'startdate' => date("Y/m/d", $startDate),
                'enddate' => date("Y/m/d", $endDate)
                ))
            ->orderBy('a.deadline_date')
            ->getQuery();

        return $query->getResult();
    }

    public function findLatest($limit)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.deadline_date >= CURRENT_DATE()')
            ->orderBy('a.deadline_date', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        return $query->getResult();
    }
}
