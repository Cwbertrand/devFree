<?php

// declare(strict_types=1);

// namespace App\EventSubscriber;

// use App\Repository\SocialRepository;
// use Symfony\Contracts\Cache\ItemInterface;
// use Symfony\Contracts\Cache\CacheInterface;
// use Symfony\Component\HttpFoundation\RequestStack;
// use Symfony\Component\HttpKernel\Event\ControllerEvent;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
// use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
// use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

// class SocialEventSubscriber implements EventSubscriberInterface
// {
//     /**
//      * @var CacheInterface
//      */
//     private $cache;

//     /**
//      * @var SessionInterface
//      */
//     private $session;

//     /**
//      * @var SocialRepository
//      */
//     private $socialRepository;

//     public function __construct(CacheInterface $cache, RequestStack $requestStack, SocialRepository $socialRepository)
//     {
//         $this->cache = $cache;
//         $this->session = $requestStack->getSession();
//         $this->socialRepository = $socialRepository;
//     }

//     public function removeCacheSocial()
//     {
//         $this->cache->delete('social');
//     }

//     public function onKernelController(ControllerEvent $event)
//     {
//         $controller = $event->getController();
//         if (!is_array($controller)) {
//             return;
//         }

//         //$this->cache->delete('social');
//         $social = $this->cache->get(
//             'social',
//             function (ItemInterface $item) {
//                 $item->expiresAfter(31536000); // 1an (60*60*24*365)

//                 return $this->socialRepository->findBySocial();
//             }
//         );

//         $this->session->set('social', json_encode($social));
//     }

//     public static function getSubscribedEvents(): array
//     {
//         return [
//             'kernel.controller' => 'onKernelController',
//             BeforeEntityDeletedEvent::class => 'removeCacheSocial',
//             BeforeEntityPersistedEvent::class => 'removeCacheSocial',
//             BeforeEntityUpdatedEvent::class => 'removeCacheSocial',
//         ];
//     }
// }
