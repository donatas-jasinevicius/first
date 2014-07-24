<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/23/14
 * Time: 11:01 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


use Donce\CurrencyConvertBundle\Entity\Currency;
use Donce\CurrencyConvertBundle\Entity\CurrencyRate;
use Donce\CurrencyConvertBundle\Manager\ExtensionManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CurrencyRateService implements CurrencyRateServiceInterface
{
    /**
     * @var ExtensionManager
     */
    private $extensionManager;

    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * @var Currency[]
     */
    private $currencies;

    /**
     * @param ExtensionManager $extensionManager
     * @param RegistryInterface $doctrine
     */
    public function __construct(ExtensionManager $extensionManager, RegistryInterface $doctrine)
    {
        $this->extensionManager = $extensionManager;
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function loadRatesByDate(\DateTime $date)
    {
        // Try to load currency rates form each extension until we get result
        foreach ($this->extensionManager->getExtensions() as $extension) {
            $rates = $extension->loadRatesByDate($date);

            $manager = $this->doctrine->getManager();

            // Delete all old rates for this date
            $manager->getRepository('DonceCurrencyConvertBundle:CurrencyRate')->deleteByDate($date);

            if (false !== $rates) {
                $this->loadCurrencies();
                foreach ($rates as $rate) {
                    if (true === isset($this->currencies[$rate['currency']])
                        && true === isset($this->currencies[$rate['baseCurrency']])
                    ) {

                        $currencyRate = new CurrencyRate();
                        $currencyRate->setDate($rate['date']);
                        $currencyRate->setCurrency($this->currencies[$rate['currency']]);
                        $currencyRate->setBaseCurrency($this->currencies[$rate['baseCurrency']]);
                        $currencyRate->setRate($rate['rate']);

                        $manager->persist($currencyRate);
                    }
                }

                $manager->flush();

                return true;
            }
        }

        return false;
    }

    private function loadCurrencies()
    {
        if (null === $this->currencies) {
            $currencies = $this->doctrine->getManager()
                ->getRepository('DonceCurrencyConvertBundle:Currency')->findAll();

            foreach ($currencies as $currency) {
                $this->currencies[$currency->getName()] = $currency;
            }
        }
    }
}
