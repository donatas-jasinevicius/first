<?php

namespace Donce\CurrencyConvertBundle\Controller;

use Donce\CurrencyConvertBundle\Form\Type\CurrencyConvertFormType;
use Donce\CurrencyConvertBundle\Service\CurrencyConvertService;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class DefaultController extends ContainerAware
{
    /**
     * @return CurrencyConvertService
     */
    private function getCurrencyConvertService()
    {
        return $this->container->get('donce_currency_convert.service.currency_convert');
    }

    /**
     * @return FormFactory
     */
    private function getFormFactory()
    {
        return $this->container->get('form.factory');
    }

    /**
     * @return EngineInterface
     */
    private function getTemplating()
    {
        return $this->container->get('templating');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function convertAction(Request $request)
    {
        $form = $this->getFormFactory()->create(new CurrencyConvertFormType());

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
            return $this->getTemplating()->renderResponse('DonceCurrencyConvertBundle:Default:form.html.twig', $data);
        }

        return $this->getTemplating()->renderResponse('DonceCurrencyConvertBundle:Default:convert.html.twig', $data);
    }
}
