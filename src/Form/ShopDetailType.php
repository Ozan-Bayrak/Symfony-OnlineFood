<?php

namespace App\Form;

use App\Entity\ShopDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shopid')
            ->add('userid')
            ->add('ordersid')
            ->add('price')
            ->add('quantity')
            ->add('amount')
            ->add('note')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShopDetail::class,
        ]);
    }
}
