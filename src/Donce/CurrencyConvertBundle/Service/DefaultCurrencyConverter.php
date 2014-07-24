<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 4:43 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


class DefaultCurrencyConverter implements CurrencyConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert($amount, $rate)
    {
        return round($amount * $rate, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function inverseConvert($amount, $rate)
    {
        return round($amount * (1 / $rate), 2);
    }
}
