<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:47 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


use Donce\CurrencyConvertBundle\Entity\Currency;
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
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    /**
     * @param CurrencyRateService $currencyRateService
     * @param RegistryInterface $doctrine
     * @param CurrencyConverterInterface $currencyConverter
     */
    public function __construct(
        CurrencyRateService $currencyRateService,
        RegistryInterface $doctrine,
        CurrencyConverterInterface $currencyConverter
    ) {
        $this->currencyRateService = $currencyRateService;
        $this->doctrine = $doctrine;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @param float $amount
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param \DateTime $date
     * @return bool|float
     */
    public function convertCurrency($amount, $currencyFrom, $currencyTo, $date)
    {
        if ($currencyFrom === $currencyTo) {
            return $amount;
        }

        //Try convert from database
        $result = $this->tryConvert($amount, $currencyFrom, $currencyTo, $date);

        //If rate not found try to load from services and then convert
        if (false === $result) {
            $this->currencyRateService->loadRatesByDate($date);

            $result = $this->tryConvert($amount, $currencyFrom, $currencyTo, $date);
        }

        return $result;
    }

    /**
     * @param CurrencyConverterInterface $currencyConverter
     */
    public function setCurrencyConverter(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Try convert currency.
     *
     * @param float $amount
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param \DateTime $date
     * @return bool|float
     */
    private function tryConvert($amount, $currencyFrom, $currencyTo, $date)
    {
        $repository = $this->doctrine->getManager()->getRepository('DonceCurrencyConvertBundle:CurrencyRate');

        $rate = $repository->getRate($date, $currencyFrom, $currencyTo);

        if (null != $rate) {
            if ($rate->getCurrency() === $currencyFrom) {
                $result = $this->currencyConverter->convert($amount, $rate->getRate());
            } else {
                $result = $this->currencyConverter->inverseConvert($amount, $rate->getRate());
            }

            return $result;
        } else {
            $rates = $repository->getJoinedRates($date, $currencyFrom, $currencyTo);

            if (2 === count($rates)) {
                //Convert to base currency
                $result = $this->currencyConverter->convert($amount, $rates[0]->getRate());

                //Convert to currencyTo
                return $this->currencyConverter->inverseConvert($result, $rates[1]->getRate());
            }
        }

        return false;
    }
}
