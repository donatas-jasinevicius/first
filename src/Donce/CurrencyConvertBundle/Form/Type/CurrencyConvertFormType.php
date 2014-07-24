<?php
/**
 * Created by PhpStorm.
 * User: donce
 * Date: 7/23/14
 * Time: 12:05 PM
 */

namespace Donce\CurrencyConvertBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CurrencyConvertFormType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'date',
            'date',
            array(
                'widget' => 'single_text',
                'constraints' => array(new NotBlank()),
            )
        );

        $builder->add(
            'currencyFrom',
            'entity',
            array(
                'class' => 'DonceCurrencyConvertBundle:Currency',
                'property' => 'name',
            )
        );

        $builder->add(
            'currencyTo',
            'entity',
            array(
                'class' => 'DonceCurrencyConvertBundle:Currency',
                'property' => 'name',
            )
        );

        $builder->add(
            'amount',
            'money',
            array(
                'currency' => false,
                'constraints' => array(new NotBlank()),
            )
        );

        $builder->add(
            'submit',
            'submit'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "currency_convert";
    }
}
