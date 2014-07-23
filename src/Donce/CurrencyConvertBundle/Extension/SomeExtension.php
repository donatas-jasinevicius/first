<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/23/14
 * Time: 10:10 PM
 */

namespace Donce\CurrencyConvertBundle\Extension;


class SomeExtension implements CurrencyRateExtensionInterface
{

    /**
     * @var string
     */
    private $url = 'http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getExchangeRate';

    /**
     * {@inheritdoc}
     */
    public function loadRatesByDate(\DateTime $date)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'some';
    }
}
