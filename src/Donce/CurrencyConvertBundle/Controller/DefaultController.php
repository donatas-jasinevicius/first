<?php

namespace Donce\CurrencyConvertBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DonceCurrencyConvertBundle:Default:index.html.twig', array('name' => $name));
    }
}
