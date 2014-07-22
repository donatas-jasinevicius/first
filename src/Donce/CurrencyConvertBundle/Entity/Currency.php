<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 10:15 PM
 */

namespace Donce\CurrencyConvertBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Currency
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var CurrencyRate
     */
    protected $currencyRates;

    public function __construct()
    {
        $this->currencyRates = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param CurrencyRate $currencyRates
     *
     * @return $this
     */
    public function setCurrencyRates($currencyRates)
    {
        $this->currencyRates = $currencyRates;

        return $this;
    }

    /**
     * @return CurrencyRate[]
     */
    public function getCurrencyRates()
    {
        return $this->currencyRates;
    }
}
