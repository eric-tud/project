<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('role', ChoiceType::class, [
                'mapped' => false,
                'required'=> true,
                'label' => 'UserType',
                'choices'=> [
                    'ROLE_USER'=>'ROLE_USER',
                    'ROLE_HEAD'=>'ROLE_HEAD',
                    'ROLE_ADMIN'=>'ROLE_ADMIN',
                ],
                'expanded'=>true,
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
