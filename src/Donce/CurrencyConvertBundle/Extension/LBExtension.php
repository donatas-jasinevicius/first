<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:24 PM
 */

namespace Donce\CurrencyConvertBundle\Extension;


class LBExtension implements CurrencyConvertExtensionInterface
{

    /**
     * @var string
     */
    private $url = 'http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getExchangeRate';

    /**
     *
     */
    public function getRate()
    {

    }
}
