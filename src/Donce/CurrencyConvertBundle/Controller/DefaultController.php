<?php

namespace Donce\CurrencyConvertBundle\Controller;

use Donce\CurrencyConvertBundle\Form\Type\CurrencyConvertFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    private function getCurrencyConvertService()
    {
        return $this->get('donce_currency_convert.service.currency_convert');
    }

    public function convertAction(Request $request)
    {
        $form = $this->createForm(new CurrencyConvertFormType());

        if (true === $request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $convertService = $this->getCurrencyConvertService();

                $formData = $form->getData();
                $data['result'] = $convertService->convertCurrency(
                    $formData['amount'],
                    $formData['currencyFrom'],
                    $formData['currencyTo'],
                    $formData['date']
                );
            }
        }

        $data['form'] = $form->createView();

        if ($request->isXmlHttpRequest()) {
            return $this->render('DonceCurrencyConvertBundle:Default:form.html.twig', $data);
        }

        return $this->render('DonceCurrencyConvertBundle:Default:convert.html.twig', $data);
    }
}
