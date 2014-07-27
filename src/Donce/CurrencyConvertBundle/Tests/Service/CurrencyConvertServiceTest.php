<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/27/14
 * Time: 3:36 PM
 */

namespace Donce\CurrencyConvertBundle\Tests\Service;

use Donce\CurrencyConvertBundle\Entity\Currency;
use Donce\CurrencyConvertBundle\Entity\CurrencyRate;
use Donce\CurrencyConvertBundle\Service\CurrencyConvertService;
use Donce\CurrencyConvertBundle\Service\DefaultCurrencyConverter;

class CurrencyConvertServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyConvertService
     */
    private $service;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $repository;

    /**
     * @var Currency[]
     */
    private $currencies = array();

    /**
     * @var CurrencyRate[]
     */
    private $currencyRates = array();

    public function setUp()
    {
        $this->repository =
            $this->getMockBuilder('Donce\CurrencyConvertBundle\Entity\Repository\CurrencyRateRepository')
                ->disableOriginalConstructor()
                ->getMock();

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $currencyRateService = $this->getMockBuilder('Donce\CurrencyConvertBundle\Service\CurrencyRateService')
            ->disableOriginalConstructor()
            ->getMock();

        $doctrine = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $doctrine->expects($this->any())
            ->method('getManager')
            ->will($this->returnValue($entityManager));

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->repository));

        $currencyRateService->expects($this->any())
            ->method('loadRatesByDate')
            ->will($this->returnValue(false));

        $this->service = new CurrencyConvertService(
            $currencyRateService,
            $doctrine,
            new DefaultCurrencyConverter()
        );

        $ltl = new Currency();
        $ltl->setName('LTL');
        $this->currencies['LTL'] = $ltl;

        $eur = new Currency();
        $eur->setName('EUR');
        $this->currencies['EUR'] = $eur;

        $usd = new Currency();
        $usd->setName('USD');
        $this->currencies['USD'] = $usd;

        $ltlToEurRate = new CurrencyRate();
        $ltlToEurRate->setRate(3.45);
        $ltlToEurRate->setCurrency($eur);
        $ltlToEurRate->setBaseCurrency($ltl);
        $this->currencyRates['ltlToEurRate'] = $ltlToEurRate;

        $ltlToUsdRate = new CurrencyRate();
        $ltlToUsdRate->setRate(2.56);
        $ltlToUsdRate->setCurrency($usd);
        $ltlToUsdRate->setBaseCurrency($ltl);
        $this->currencyRates['ltlToUsdRate'] = $ltlToUsdRate;

    }

    public function testConvertCurrencyOneEntity()
    {
        $date = new \DateTime();

        $this->repository->expects($this->any())
            ->method('getRate')
            ->will($this->returnValue($this->currencyRates['ltlToEurRate']));

        $this->assertEquals(
            2.9,
            $this->service->convertCurrency(10, $this->currencies['LTL'], $this->currencies['EUR'], $date)
        );
        $this->assertEquals(
            34.5,
            $this->service->convertCurrency(10, $this->currencies['EUR'], $this->currencies['LTL'], $date)
        );
    }

    public function testConvertCurrencyJoinEntity()
    {
        $date = new \DateTime();

        $this->repository->expects($this->any())
            ->method('getRate')
            ->will($this->returnValue(false));

        $this->repository->expects($this->any())
            ->method('getJoinedRates')
            ->will(
                $this->returnValue(array($this->currencyRates['ltlToEurRate'], $this->currencyRates['ltlToUsdRate']))
            );

        $this->assertEquals(
            13.48,
            $this->service->convertCurrency(10, $this->currencies['EUR'], $this->currencies['USD'], $date)
        );
    }

    public function testConvertCurrencyJoinEntityReverse()
    {
        $date = new \DateTime();

        $this->repository->expects($this->any())
            ->method('getRate')
            ->will($this->returnValue(false));

        $this->repository->expects($this->any())
            ->method('getJoinedRates')
            ->will(
                $this->returnValue(array($this->currencyRates['ltlToUsdRate'], $this->currencyRates['ltlToEurRate']))
            );

        $this->assertEquals(
            7.42,
            $this->service->convertCurrency(10, $this->currencies['USD'], $this->currencies['EUR'], $date)
        );
    }

    public function testConvertCurrencyFalse()
    {
        $date = new \DateTime();

        $this->repository->expects($this->any())
            ->method('getRate')
            ->will($this->returnValue(false));

        $this->repository->expects($this->any())
            ->method('getJoinedRates')
            ->will($this->returnValue(array()));

        $this->assertEquals(
            false,
            $this->service->convertCurrency(10, $this->currencies['USD'], $this->currencies['EUR'], $date)
        );
    }
}
