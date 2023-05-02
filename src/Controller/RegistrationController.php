<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Mailer\RegisterMailer;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Twig\Runtime\ConfigurationRuntime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
        /**
     * @var ConfigurationRuntime
     */
    private $configuration;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserPasswordHasherInterface
     */
    private $userPasswordHasher;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @param ConfigurationRuntime        $configuration      comment
     * @param EntityManagerInterface      $entityManager      comment
     * @param UserPasswordHasherInterface $userPasswordHasher comment
     * @param TranslatorInterface         $translator         comment
     * @param UrlGeneratorInterface       $urlGenerator       comment
     */

    public function __construct(
        ConfigurationRuntime $configuration,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        TranslatorInterface $translator,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->configuration = $configuration;
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->translator = $translator;
        $this->urlGenerator = $urlGenerator;
    }

    #[Route('/register_page', name: "register_page")]
    public function registerPage(): Response
    {
        return $this->render('registration/registerpage.html.twig');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, RegisterMailer $registerMailer, EmailVerifier $emailVerifier): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        // , [
        //     'sitename' => $this->configuration->get('site', 'name'),
        //     'terms_of_sales' => $this->urlGenerator->generate('app_terms_conditions'),
        //     'privacy_policy' => $this->urlGenerator->generate('app_privacy_policy'),
        // ]
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // generate a signed url and email it to the user
            $emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(Address::create($this->configuration->get('site', 'name').' <'.$this->configuration->get('mailer', 'mailreply').'>')) //new Address('noreplydevfree@gmail.fr', 'DevFree')
                    ->to($user->getEmail())
                    ->replyTo($this->configuration->get('mailer', 'mailreply'))
                    ->priority(Email::PRIORITY_HIGH)
                    ->subject($this->translator->trans('register.subject', [
                        '%sitename' => $this->configuration->get('site', 'name'),
                    ], 'mailer'))
                    ->context([
                        'sitename' => $this->configuration->get('site', 'name'),
                        'fullname' => $user->getClient()->getFullname(),
                    ])
                    ->htmlTemplate('_mailer/'.$request->getLocale().'/confirmation_email.html.twig')
            );
            
            $this->addFlash('warning', $this->translator->trans('REGISTER-SEND-VERIFY-EMAIL'));
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, EmailVerifier $emailVerifier): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }
}
