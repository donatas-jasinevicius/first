<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:24 PM
 */

namespace Donce\CurrencyConvertBundle\Extension;


use Donce\CurrencyConvertBundle\Model\LBCurrencyRateItem;
use JMS\Serializer\Serializer;

class LBExtension implements CurrencyRateExtensionInterface
{
    /**
     * @var string
     */
    private $url = 'http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getExchangeRatesByDate';

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var string
     */
    private $baseCurrency = 'LTL';

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function loadRatesByDate(\DateTime $date)
    {
        $xml = $this->getXml($date);

        $lbRates = $this->serializer->deserialize($xml, 'Donce\CurrencyConvertBundle\Model\LBRates', 'xml');

        if (true === empty($lbRates->getItems())) {
            return false;
        }

        $result = array();
        /** @var LBCurrencyRateItem $lbRate */
        foreach ($lbRates->getItems() as $lbRate) {
            $result[] = array(
                'date' => \DateTime::createFromFormat('Y.m.d', $lbRate->getDate()),
                'currency' => $lbRate->getCurrency(),
                'baseCurrency' => $this->baseCurrency,
                'rate' => $lbRate->getRate() / $lbRate->getQuantity(),
            );
        }

        return $result;
    }

    /**
     * @param $date
     *
     * @return string
     */
    private function getXml($date)
    {
        $post['Date'] = $date->format('Y-m-d');

        //open connection
        $curl = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, count($post));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));

        //execute post
        $xml = curl_exec($curl);

        //close connection
        curl_close($curl);

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 5;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'lb';
    }
}
