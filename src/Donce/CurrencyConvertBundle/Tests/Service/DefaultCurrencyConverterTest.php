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
    public function testConvert()
    {
        $converter = new DefaultCurrencyConverter();

        $this->assertEquals(36.83, $converter->convert(5.2621, 7));
        $this->assertEquals(35, $converter->convert(5, 7));

        $this->assertEquals(0.75, $converter->inverseConvert(5.2621, 7));
        $this->assertEquals(0.71, $converter->inverseConvert(5, 7));
    }
}
