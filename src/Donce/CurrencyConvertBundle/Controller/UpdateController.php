<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/23/14
 * Time: 10:55 PM
 */

namespace Donce\CurrencyConvertBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UpdateController extends Controller
{
    private function getCurrencyRateService()
    {
        return $this->get('donce_currency_convert.service.currency_rate');
    }
    public function updateAction()
    {
        $date = new \DateTime();

        $rateService = $this->getCurrencyRateService();

        $rateService->loadRatesByDate($date);

    }
}
