<?php

namespace App\UseCase\UserList;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserListForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Name',
            ]])
            ->add('phone', TextType::class, [
                'required' => false, 'attr' => [
                'placeholder' => 'Phone',
            ]])
            ->add('email', TextType::class, [
                'required' => false, 'attr' => [
                'placeholder' => 'Email',
            ]])
            ->add('education', TextType::class, [
                'required' => false, 'attr' => [
                'placeholder' => 'Education',
            ]])
            ->add('isPersonalData', TextType::class, [
                'required' => false, 'attr' => [
                    'placeholder' => 'Personal data',
                ]])
            ->add('score', NumberType::class, [
                'required' => false, 'attr' => [
                    'placeholder' => 'Personal data',
                ]])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }


}