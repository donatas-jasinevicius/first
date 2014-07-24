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
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('donce_currency_convert.extension.manager')) {
            return;
        }

        $definition = $container->getDefinition(
            'donce_currency_convert.extension.manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'currency_convert.rate_extension'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addExtension',
                array(new Reference($id))
            );
        }
    }
}
