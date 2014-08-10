<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 9:29 PM
 */

namespace Donce\CurrencyConvertBundle\Tests\Service;


use Donce\CurrencyConvertBundle\Service\DefaultCurrencyConverter;

class DefaultCurrencyConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $amount
     * @param $rate
     * @param $result
     *
     * @dataProvider convertDataProvider
     */
    public function testConvert($amount, $rate, $result)
    {
        $converter = new DefaultCurrencyConverter();

        $this->assertEquals($result, $converter->convert($amount, $rate));
    }

    /**
     * @param $amount
     * @param $rate
     * @param $result
     *
     * @dataProvider inverseConvertDataProvider
     */
    public function testInverseConvert($amount, $rate, $result)
    {
        $converter = new DefaultCurrencyConverter();

        $this->assertEquals($result, $converter->inverseConvert($amount, $rate));
    }

    public function convertDataProvider()
    {
        return array(
            array(5.2621, 7, 36.83),
            array(5, 7, 35),
        );
    }

    public function inverseConvertDataProvider()
    {
        return array(
            array(5.2621, 7, 0.75),
            array(5, 7, 0.71),
        );
    }
}
