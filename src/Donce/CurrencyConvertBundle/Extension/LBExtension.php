<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:24 PM
 */

namespace Donce\CurrencyConvertBundle\Extension;


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


    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function loadRatesByDate(\DateTime $date)
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
        $result = curl_exec($curl);

        //close connection
        curl_close($curl);

        $result = '<ExchangeRates>
        <item>
        <date>2012.12.01</date><currency>AED</currency><quantity>10</quantity><rate>7.2832</rate><unit>LTL per 10 currency units</unit>
        </item>
        <item>
        <date>2012.12.01</date><currency>AFN</currency><quantity>100</quantity><rate>5.0493</rate><unit>LTL per 100 currency units</unit>
        </item>
        </ExchangeRates>';
        $data = $this->serializer->deserialize($result, 'Donce\CurrencyConvertBundle\Model\LBRates', 'xml');
        var_dump($data);die('wtf');

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
