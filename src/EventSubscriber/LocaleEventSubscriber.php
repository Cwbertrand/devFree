<?php

// namespace App\EventSubscriber;

// use App\Twig\Runtime\ConfigurationRuntime;
// use Symfony\Component\HttpKernel\KernelEvents;
// use Symfony\Component\HttpKernel\Event\RequestEvent;
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;

// class LocaleEventSubscriber implements EventSubscriberInterface
// {
//     /**
//      * @var string
//      */
//     private $defaultLocale;

//     /**
//      * @var ConfigurationRuntime
//      */
//     private $configuration;

//     public function __construct(string $defaultLocale, ConfigurationRuntime $configuration)
//     {
//         $this->defaultLocale = $defaultLocale;
//         $this->configuration = $configuration;
//     }

//     /**
//      * Kernel request.
//      *
//      * @param RequestEvent $event comment
//      *
//      * @return void
//      */
//     public function onKernelRequest(RequestEvent $event)
//     {
//         $request = $event->getRequest();

//         // essaye de voir si les paramètres régionaux ont été définis comme paramètre de routage _locale
//         if ($locale = $request->attributes->get('_locale')) {
//             $request->getSession()->set('_locale', $locale);
//         } else {
//             // si aucune locale explicite n'a été définie sur cette demande, on utilise la session et la langue par défaut
//             $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
//         }
        
//         if (null === $request->getSession()->get('timezone')) {
//             //date_default_timezone_set($this->configuration->get('site', 'timezone'));
//         } else {
//             date_default_timezone_set($request->getSession()->get('timezone'));
//         }
//     }

//     public static function getSubscribedEvents(): array
//     {
//         return [
//             // doit être enregistré avant (c'est-à-dire avec une priorité plus élevée que) l'écouteur de paramètres régionaux par défaut
//             KernelEvents::REQUEST => [['onKernelRequest', 20]],
//         ];
//     }
// }