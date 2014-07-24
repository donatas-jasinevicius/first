<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 4:42 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


interface CurrencyConverterInterface
{
    /**
     * @param float $amount
     * @param float $rate
     * @return float
     */
    public function convert($amount, $rate);

    /**
     * @param float $amount
     * @param float $rate
     * @return float
     */
    public function inverseConvert($amount, $rate);
}
