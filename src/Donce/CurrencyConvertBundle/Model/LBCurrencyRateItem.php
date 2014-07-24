<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 12:47 AM
 */

namespace Donce\CurrencyConvertBundle\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\SerializedName;


class LBCurrencyRateItem
{
    /**
     * @var string
     * @SerializedName("date")
     * @Type("string")
     */
    private $date;

    /**
     * @var string
     * @SerializedName("currency")
     * @Type("string")
     */
    private $currency;

    /**
     * @var string
     * @SerializedName("quantity")
     * @Type("integer")
     */
    private $quantity;

    /**
     * @var string
     * @SerializedName("rate")
     * @Type("float")
     */
    private $rate;

    /**
     * @var string
     * @SerializedName("unit")
     * @Type("string")
     */
    private $unit;

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
