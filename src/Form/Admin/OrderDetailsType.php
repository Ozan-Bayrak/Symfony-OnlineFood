<?php

namespace App\Form\Admin;

use App\Entity\Admin\OrderDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userid')
            ->add('foodid')
            ->add('ordersid')
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('phone')
            ->add('amount')
            ->add('total')
            ->add('note')
            ->add('messages')
            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'New'=>'Read',
                    'Accepted'=>'Accepted',
                    'Cancelled'=>'Canceled',
                    'Completed'=>'Completed',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderDetails::class,
        ]);
    }
}
