<?php

namespace Donce\CurrencyConvertBundle\Controller;

use Donce\CurrencyConvertBundle\Form\Type\CurrencyConvertFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function convertAction(Request $request)
    {

        $form = $this->createForm(new CurrencyConvertFormType());

        if (true === $request->isMethod('POST')) {

            $form->submit($request);
            if ($form->isValid()) {
                $formData = $form->getData();

                $data['result'] = $formData['amount'] * 1.3;
            }
        }

        $data['form'] = $form->createView();

        return $this->render('DonceCurrencyConvertBundle:Default:convert.html.twig', $data);
    }
}
