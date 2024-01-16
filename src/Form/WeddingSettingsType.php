<?php

namespace App\Form;

use App\Entity\UserProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class WeddingSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bride_name', TextType::class, [
                'label' => "Imię Panny Młodej",
                'attr' => [
                    'placeholder' => "Imię Panny Młodej"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać imię Panny Młodej.',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Imię powinno składać się z przynajmniej {{ limit }} znaków.',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                        'maxMessage' => 'Imię powinno składać się z maksymalnie {{ limit }} znaków.',
                    ]),

                ],
            ])
            ->add('groom_name',  TextType::class, [
                'label' => "Imię Pana Młodego",
                'attr' => [
                    'placeholder' => "Imię Pana Młodego"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać imię Pana Młodego.',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Imię powinno składać się z przynajmniej {{ limit }} znaków.',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                        'maxMessage' => 'Imię powinno składać się z maksymalnie {{ limit }} znaków.',
                    ]),

                ],
            ])
            ->add('wedding_date', DateTimeType::class, [
                'label' => "Data ślubu",
                'attr' => [
                    'placeholder' => "Data ślubu"
                ],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
        ]);
    }
}
