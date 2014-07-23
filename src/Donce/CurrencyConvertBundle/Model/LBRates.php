<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/24/14
 * Time: 12:41 AM
 */

namespace Donce\CurrencyConvertBundle\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\SerializedName;

class LBRates
{
    /**
     * @var LBCurrencyRateItem[]
     * @SerializedName("items")
     * @XmlList(entry="item")
     * @Type("array<Donce\CurrencyConvertBundle\Model\LBCurrencyRateItem>")
     */
    private $items = array();

    /**
     * @param LBCurrencyRateItem[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return LBCurrencyRateItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
