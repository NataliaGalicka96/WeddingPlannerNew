<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa kontaktu',
                'attr' => [
                    'placeholder' => "Nazwa kontaktu"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać nazwę kontaktu.',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Nazwa powinna składać się z przynajmniej {{ limit }} znaków.',
                        // max length allowed by Symfony for security reasons
                        'max' => 100,
                        'maxMessage' => 'Nazwa powinna składać się z maksymalnie {{ limit }} znaków.',
                    ]),

                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'E-mail'
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Proszę podać adres e-mail.',
                    ]),
                ],
            ])
            ->add('phoneNumber', IntegerType::class, [
                'label' => 'Numer telefonu',
                'attr' => [
                    'placeholder' => "Numer telefonu"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
            ])
            ->add('street', TextType::class, [
                'label' => 'Nazwa ulicy',
                'attr' => [
                    'placeholder' => "Nazwa ulicy"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
            ])
            ->add('homeNumber', IntegerType::class, [
                'label' => 'Numer domu',
                'attr' => [
                    'placeholder' => "Numer domu"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'

                ],
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'Miasto',
                'attr' => [
                    'placeholder' => "Miasto"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
            ])
            ->add('postalcode', TextType::class, [
                'label' => 'Kod pocztowy',
                'attr' => [
                    'placeholder' => "Kod pocztowy"
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3'
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
