<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/22/14
 * Time: 9:31 PM
 */

namespace Donce\CurrencyConvertBundle\DependencyInjection\CompilerPass;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CurrencyConvertCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('donce_currency_convert.manager.currency_convert')) {
            return;
        }

        $definition = $container->getDefinition(
            'donce_currency_convert.manager.currency_convert'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'currency_convert.extension'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addExtension',
                array(new Reference($id), $attributes['alias'])
            );
        }
    }
}
