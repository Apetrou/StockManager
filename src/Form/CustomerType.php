<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array('attr' => array('style' => 'width: 400px')))
            ->add('lastName', null, array('attr' => array('style' => 'width: 400px')))
            ->add('telephoneNumber', null, array('attr' => array('style' => 'width: 400px')))
            ->add('shippingMethod', null, array('attr' => array('style' => 'width: 400px')))
            ->add('comments', null, array('attr' => array('style' => 'width: 400px')))
            ->add('area', null, array('attr' => array('style' => 'width: 400px')))
            ->add('city', null, array('attr' => array('style' => 'width: 400px')))
            ->add('animals', null, array('attr' => array('style' => 'width: 400px')))
            ->add('risk', null, array('attr' => array('style' => 'width: 400px')))
            ->add('paymentMethod', null, array('attr' => array('style' => 'width: 400px')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
