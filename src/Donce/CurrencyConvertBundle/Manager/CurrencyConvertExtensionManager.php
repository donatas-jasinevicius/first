<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:18 PM
 */

namespace Donce\CurrencyConvertBundle\Manager;


use Donce\CurrencyConvertBundle\Extension\CurrencyConvertExtensionInterface;

class CurrencyConvertExtensionManager
{
    private $extensions = array();

    /**
     * Add currency convert extension.
     *
     * @param CurrencyConvertExtensionInterface $extension
     * @param string $alias
     */
    public function addExtension(CurrencyConvertExtensionInterface $extension, $alias)
    {
        $this->extensions[$alias] = $extension;
    }
}
