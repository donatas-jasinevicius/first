<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:27 PM
 */

namespace Donce\CurrencyConvertBundle\Extension;


interface CurrencyRateExtensionInterface
{
    /**
     * Loads currency rates by date.
     *
     * @param \DateTime $date
     *
     * @return bool|array
     */
    public function loadRatesByDate(\DateTime $date);

    /**
     * Get extensions priority (higher first).
     *
     * @return int
     */
    public function getPriority();

    /**
     * @return string
     */
    public function getId();
}
