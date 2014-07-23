<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/23/14
 * Time: 11:01 PM
 */

namespace Donce\CurrencyConvertBundle\Service;


use Donce\CurrencyConvertBundle\Manager\ExtensionManager;

class CurrencyRateService
{
    /**
     * @var ExtensionManager
     */
    private $extensionManager;

    /**
     * @param ExtensionManager $extensionManager
     */
    public function __construct(ExtensionManager $extensionManager)
    {
        $this->extensionManager = $extensionManager;
    }

    /**
     * @param \DateTime $date
     */
    public function loadRatesByDate(\DateTime $date)
    {
        // Try to load currency rates form each extension until we get result
        foreach ($this->extensionManager->getExtensions() as $extension) {
            $rates = $extension->loadRatesByDate($date);

            if (false !== $rates) {
                var_dump($rates); die;

                break;
            }
        }

    }
}
