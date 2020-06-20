<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TextType::class, ['label' => 'Telefon', 'mapped' => false])
            ->add('email', TextType::class, ['label' => 'Email', 'mapped' => false])
            ->add('message', TextareaType::class, ['label' => 'Wiadomość', 'mapped' => false])
            ->add('save', SubmitType::class, ['label' => 'Wyślij wiadomość', 'attr' => ['class' => 'btn btn-primary py-3 px-5']])
        ;
    }
}
