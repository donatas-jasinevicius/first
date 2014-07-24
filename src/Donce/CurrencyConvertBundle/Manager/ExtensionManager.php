<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:18 PM
 */

namespace Donce\CurrencyConvertBundle\Manager;


use Donce\CurrencyConvertBundle\Extension\CurrencyRateExtensionInterface;

class ExtensionManager
{
    /**
     * @var CurrencyRateExtensionInterface[]
     */
    private $extensions = array();

    /**
     * @var bool
     */
    private $sorted = false;

    /**
     * @param CurrencyRateExtensionInterface $extension
     */
    public function addExtension(CurrencyRateExtensionInterface $extension)
    {
        if (null !== $extension) {
            $this->sorted = false;
            $this->extensions[$extension->getId()] = $extension;
        }
    }

    /**
     * @return CurrencyRateExtensionInterface[]
     */
    public function getExtensions()
    {
        if (false === $this->sorted) {
            usort($this->extensions, array($this, "sortCmp"));
            $this->sorted = true;
        }
        return $this->extensions;
    }

    /**
     * @param string $extensionId
     *
     * @return bool|CurrencyRateExtensionInterface
     */
    public function getExtensionById($extensionId)
    {
        foreach ($this->extensions as $extension) {
            if ($extensionId === $extension->getId()) {
                return $extension;
            }
        }

        return false;
    }

    /**
     * Sort compare.
     *
     * @param CurrencyRateExtensionInterface $a
     * @param CurrencyRateExtensionInterface $b
     *
     * @return int
     */
    private function sortCmp($a, $b)
    {
        if ($a->getPriority() == $b->getPriority()) {
            return 0;
        }
        return ($a->getPriority() > $b->getPriority()) ? -1 : 1;
    }
}
