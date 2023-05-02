<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', ClientType::class, [
                'label' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'autocomplete' => 'new-email',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => new TranslatableMessage('CONTRAINTS-NOT-BLANK'),
                    ]),
                    new Regex([
                        'pattern' => '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,8}+$/',
                        'match' => true,
                        'message' => new TranslatableMessage('EMAIL-INVALID'),
                    ]),
                ],
                // 'help' => new TranslatableMessage('CONTRAINTS-EMAIL'),
                // 'help_html' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => new TranslatableMessage('The password and the confirmation password has to be identical.'),
                'mapped' => false,
                'required' => true,
                'first_options' => [
                    'label' => false,
                    'attr' => ['class' => 'input_resize'],
                    'help' => new TranslatableMessage('CONTRAINTS-PASSWORD'),
                    'help_html' => true,
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => ['class' => 'input_resize']
                ],
                'constraints' => [
                    // https://regex101.com/r/jFUJC4/1
                    // new Regex([
                    //     'pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#?!}{)=+|(@_$%^&*-])[a-zA-Z\d#?!}{)=+|(@_$%^&*-]/',
                    //     'match' => true,
                    //     'message' => new TranslatableMessage('CONTRAINT-REGEX-PASSWORD'),
                    // ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => new TranslatableMessage('CONTRAINTS-MIN-LENGTH', ['%length%' => 6]),
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
