<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/23/14
 * Time: 10:55 PM
 */

namespace Donce\CurrencyConvertBundle\Controller;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;

class UpdateController extends ContainerAware
{
    private function getCurrencyRateService()
    {
        return $this->container->get('donce_currency_convert.service.currency_rate');
    }
    public function updateAction()
    {
        $date = new \DateTime();

        $rateService = $this->getCurrencyRateService();

        $result = $rateService->loadRatesByDate($date);

        if (true === $result) {
            $response = 'Updated successfully.';
        } else {
            $response = 'Update failed.';
        }

        return new Response($response);
    }
}
