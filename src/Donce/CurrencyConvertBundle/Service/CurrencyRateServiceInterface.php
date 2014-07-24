<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 10:15 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


interface CurrencyRateServiceInterface
{
    /**
     * Load rates to databse by date.
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    public function loadRatesByDate(\DateTime $date);
}
