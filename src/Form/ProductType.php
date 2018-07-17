<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('attr' => array('style' => 'width: 400px')))
            ->add('artifactNumber', null, array('attr' => array('style' => 'width: 400px')))
            ->add('cataloguePage', null, array('attr' => array('style' => 'width: 400px')))
            ->add('quantity', null, array('attr' => array('style' => 'width: 400px')))
            ->add('cost', null, array('attr' => array('style' => 'width: 400px')))
            ->add('comments', null, array('attr' => array('style' => 'width: 400px')))
            ->add('stock', null, array('attr' => array('style' => 'width: 400px')))
            ->add('category', null, array('attr' => array('style' => 'width: 400px')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
