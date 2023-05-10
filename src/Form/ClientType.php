<?php

namespace App\Form;

use App\Entity\Client;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' =>'votre nom'
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => new TranslatableMessage('ASSETS-MIN-PSEUDO'),
                        'max' => 30,
                        'maxMessage' => new TranslatableMessage('ASSETS-MAX-PSEUDO'),
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z-\']+$/',
                        'match' => true,
                        'message' => new TranslatableMessage('CONTRAINTS-REGEX-PSEUDO'),
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' =>'votre prénom'
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => new TranslatableMessage('ASSETS-MIN-PSEUDO'),
                        'max' => 30,
                        'maxMessage' => new TranslatableMessage('ASSETS-MAX-PSEUDO'),
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z-\']+$/',
                        'match' => true,
                        'message' => new TranslatableMessage('CONTRAINTS-REGEX-PSEUDO'),
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
