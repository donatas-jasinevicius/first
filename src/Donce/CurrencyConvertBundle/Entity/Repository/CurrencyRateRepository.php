<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 10:16 AM
 */

namespace Donce\CurrencyConvertBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Donce\CurrencyConvertBundle\Entity\Currency;
use Donce\CurrencyConvertBundle\Entity\CurrencyRate;

class CurrencyRateRepository extends EntityRepository
{
    /**
     * @param \DateTime $date
     */
    public function deleteByDate(\DateTime $date)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->delete('Donce\CurrencyConvertBundle\Entity\CurrencyRate', 'cr');
        $qb->where($qb->expr()->eq('cr.date', ':date'));
        $qb->setParameter('date', $date->format('Y-m-d'));

        $qb->getQuery()->execute();
    }

    /**
     * Get rate entity.
     *
     * @param \DateTime $date
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     *
     * @return CurrencyRate
     */
    public function getRate(\DateTime $date, Currency $currencyFrom, Currency $currencyTo)
    {
        $qb = $this->createQueryBuilder('cr');

        $qb->select('cr');
        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('cr.date', ':date'),
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        $qb->expr()->eq('cr.currency', ':currency'),
                        $qb->expr()->eq('cr.baseCurrency', ':baseCurrency')
                    ),
                    $qb->expr()->andX(
                        $qb->expr()->eq('cr.currency', ':baseCurrency'),
                        $qb->expr()->eq('cr.baseCurrency', ':currency')
                    )
                )
            )
        );

        $qb->setParameter('date', $date->format('Y-m-d'));
        $qb->setParameter('currency', $currencyTo);
        $qb->setParameter('baseCurrency', $currencyFrom);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;

    }

    /**
     * Get two rate entities connect on base currency.
     *
     * @param \DateTime $date
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     *
     * @return CurrencyRate[]
     */
    public function getJoinedRates(\DateTime $date, Currency $currencyFrom, Currency $currencyTo)
    {
        $qb = $this->createQueryBuilder('cr');

        $qb->select('cr, crj');
        $qb->innerJoin(
            'Donce\CurrencyConvertBundle\Entity\CurrencyRate',
            'crj',
            Join::WITH,
            'cr.baseCurrency = crj.baseCurrency'
        );
        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('cr.date', ':date'),
                $qb->expr()->eq('crj.date', ':date'),
                $qb->expr()->andX(
                    $qb->expr()->eq('cr.currency', ':currencyFrom'),
                    $qb->expr()->eq('crj.currency', ':currencyTo')
                )
            )
        );

        $qb->setParameter('date', $date->format('Y-m-d'));
        $qb->setParameter('currencyTo', $currencyTo);
        $qb->setParameter('currencyFrom', $currencyFrom);

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
