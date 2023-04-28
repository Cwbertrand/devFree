<?php

// namespace App\EventSubscriber;

// use App\Entity\User;
// use App\Repository\UserRepository;
// use App\Twig\Runtime\ConfigurationRuntime;
// use Symfony\Bundle\SecurityBundle\Security;
// use Symfony\Component\HttpKernel\KernelEvents;
// use Symfony\Component\HttpFoundation\RequestStack;
// use Symfony\Component\HttpFoundation\RedirectResponse;
// use Symfony\Contracts\Translation\TranslatorInterface;
// use Symfony\Component\HttpKernel\Event\ControllerEvent;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
// use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;

// class UserSessionEventSubscriber implements EventSubscriberInterface
// {
//     /**
//      * @var SessionInterface
//      */
//     private $session;

//     /**
//      * @var UserRepository
//      */
//     private $userRepository;

//     /**
//      * @var Security
//      */
//     private $security;

//     /**
//      * @var UrlGeneratorInterface
//      */
//     private $urlGenerator;

//     public function __construct(
//         RequestStack $requestStack,
//         UserRepository $userRepository,
//         Security $security,
//         UrlGeneratorInterface $urlGenerator
//     ) {
//         $this->session = $requestStack->getSession();
//         $this->userRepository = $userRepository;
//         $this->security = $security;
//         $this->urlGenerator = $urlGenerator;
//     }

//     /**
//      * Met à jour la session de l'utilisateur
//      * Si la session est dépassée l'utilisateur sera déconnecté.
//      *
//      * @param ControllerEvent $event Objet
//      */
//     public function onKernelController(ControllerEvent $event)
//     {
//         $controller = $event->getController();
//         if (!is_array($controller)) {
//             return;
//         }

//         /**
//          * @var User
//          */
//         $user = $this->security->getUser();

//         // Session profil
//         if ($user) {
//             if ($user->getTimeSession() > time() && isset($_COOKIE['_token']) && $_COOKIE['_token'] === $user->getToken()) {
//                 $this->userRepository->updateTimeSession($user);
//             } else {
//                 $this->userRepository->logoutUser($user);
//                 $this->session->invalidate();
//                 $event->setController(function () {
//                     return new RedirectResponse(
//                         $this->urlGenerator->generate('app_logout')
//                     );
//                 });
//             }
//         }
//     }

//     public static function getSubscribedEvents(): array
//     {
//         return [
//             KernelEvents::CONTROLLER => [['onKernelController', 1]],
//         ];
//     }
// }
