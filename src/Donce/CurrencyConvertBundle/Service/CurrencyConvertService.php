<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:47 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


use Symfony\Bridge\Doctrine\RegistryInterface;

class CurrencyConvertService
{
    /**
     * @var CurrencyRateService
     */
    private $currencyRateService;
    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * @param CurrencyRateService $currencyRateService
     * @param RegistryInterface $doctrine
     */
    public function __construct(CurrencyRateService $currencyRateService, RegistryInterface $doctrine)
    {
        $this->currencyRateService = $currencyRateService;
        $this->doctrine = $doctrine;
    }

    public function convertCurrency($amount, $currencyFrom, $currencyTo, $date)
    {
        $repository = $this->doctrine->getManager()->getRepository('DonceCurrencyConvertBundle:CurrencyRate');

        $rate = $repository->getRate($date, $currencyFrom, $currencyTo);

        if (null != $rate) {
            if ($rate->getCurrency() === $currencyFrom) {
                $result = $amount * $rate->getRate();
            } else {
                $result = $amount * (1 / $rate->getRate());
            }

            return $result;
        } else {
            $repository->getJoinedRates($date, $currencyFrom, $currencyTo);
        }

        return false;
    }
}
