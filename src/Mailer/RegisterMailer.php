<?php

namespace App\Mailer;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Twig\Runtime\SocieteRuntime;
use App\Twig\Runtime\ConfigurationRuntime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegisterMailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var ConfigurationRuntime
     */
    private $configuration;

    /**
     * @var SocieteRuntime
     */
    private $societe;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @param MailerInterface       $mailer        comment
     * @param ConfigurationRuntime  $configuration comment
     * @param SocieteRuntime        $societe       comment
     * @param TranslatorInterface   $translator    comment
     * @param UrlGeneratorInterface $urlGenerator  comment
     */
    public function __construct(
        MailerInterface $mailer,
        ConfigurationRuntime $configuration,
        SocieteRuntime $societe,
        TranslatorInterface $translator,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->mailer = $mailer;
        $this->configuration = $configuration;
        $this->societe = $societe;
        $this->translator = $translator;
        $this->urlGenerator = $urlGenerator;
    }

    // /**
    //  * Send mail registration.
    //  *
    //  * @param User $user comment
    //  *
    //  * @return void
    //  */
    // public function send(User $user)
    // {
    //     $email = (new Email())
    //         ->from(Address::create($this->configuration->get('site', 'name').' <'.$this->configuration->get('mailer', 'mailreply').'>'))
    //         ->to($user->getEmail())
    //         ->replyTo($this->configuration->get('mailer', 'mailreply'))
    //         ->priority(Email::PRIORITY_HIGH)
    //         ->subject($this->translator->trans('register.subject', [
    //             '%sitename' => $this->configuration->get('site', 'name'),
    //         ], 'mailer'))
    //         ->html($this->translator->trans('register.content', [
    //             '%sitename%' => $this->configuration->get('site', 'name'),
    //             '%fullname%' => $user->getClient()->getFullname(),
    //             '%link%' => $this->urlGenerator->generate(
    //                 'app_login_token',
    //                 ['token' => sha1($user->getId().'|**--**|'.$user->getEmail())],
    //                 UrlGeneratorInterface::ABSOLUTE_URL
    //             ),
    //         ], 'mailer'));

    //     $this->mailer->send($email);
    // }

    /**
     * Send mail registration with template.
     *
     * @param User $user comment
     *
     * @return void
     */
    public function sendMailWithTemplate(User $user, string $locale)
    {
        $email = (new TemplatedEmail())
            ->from(Address::create($this->configuration->get('site', 'name').' <'.$this->configuration->get('mailer', 'mailreply').'>'))
            ->to($user->getEmail())
            ->replyTo($this->configuration->get('mailer', 'mailreply'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject($this->translator->trans('register.subject', [
                '%sitename' => $this->configuration->get('site', 'name'),
            ], 'mailer'))
            ->context([
                'sitename' => $this->configuration->get('site', 'name'),
                'fullname' => $user->getClient()->getFullname(),
                'link' => $this->urlGenerator->generate(
                    'app_login',
                    ['token' => sha1($user->getId().'|**--**|'.$user->getEmail())],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ])
            ->htmlTemplate('_mailer/'.strtolower($locale).'/confirmation_email.html.twig');

        $this->mailer->send($email);
    }
}
