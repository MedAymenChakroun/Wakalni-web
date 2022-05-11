<?php

namespace App\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'User' => 'ROLE_USER',
                    'Chef' => 'ROLE_CHEF',
                    'Livreur' => 'ROLE_LIVREUR'
                ]
            ])
            ->add('email', Emailtype::class)
            ->add('firstname')
            ->add('lastname')
            ->add('password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'confirm password']
            ])
            ->add('age', NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre age',
                    ]),
                    new LessThan([
                        'value' => 150,
                        'message' => 'Entrez un age valide'
                    ]),
                    new GreaterThan([
                        'value' => 12,
                        'message' => 'Vous devez etre plus que 12 ans'
                    ])
                ]
            ])
            ->add('phonenumber', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/\d{8}/',
                        'message' => 'Entrez un numero valide'
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Choisissez votre photo' ,
                'mapped' => false,])

            ->add('captcha', CaptchaType::class,[
                    'invalid_message' => 'Code incorrect',
                ]

            );
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
