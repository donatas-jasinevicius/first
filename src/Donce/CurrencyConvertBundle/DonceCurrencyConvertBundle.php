<?php

namespace Donce\CurrencyConvertBundle;

use Donce\CurrencyConvertBundle\DependencyInjection\CompilerPass\CurrencyConvertCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DonceCurrencyConvertBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CurrencyConvertCompilerPass());
    }
}
