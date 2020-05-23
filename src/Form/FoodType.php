<?php

namespace App\Form;

use App\Entity\Food;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image', FileType::class, [
                'label'=> 'Food Main Image',
                'mapped'=> false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/*',],
                        'mimeTypesMessage' => 'please upload a valid Image File',
                    ])
                ],
            ])
            ->add('details',CKEditorType::class, array(
                'config'=> array(
                    'uiColor'=> '#ffffff',
                ),
            ))
            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'true'=>'true',
                    'false'=>'false'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
