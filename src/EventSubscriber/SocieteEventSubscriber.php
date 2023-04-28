<?php

namespace App\EventSubscriber;

use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SocieteEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(ParameterBagInterface $params, CacheInterface $cache, RequestStack $requestStack)
    {
        $this->file = $params->get('app_root').'/config/societe.yaml';
        $this->cache = $cache;
        $this->session = $requestStack->getSession();
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        // $this->cache->delete('societe');
        $societe = $this->cache->get(
            'societe',
            function (ItemInterface $item) {
                $item->expiresAfter(31536000); // 1an (60*60*24*365)

                return \file_exists($this->file) ? Yaml::parseFile($this->file) : [];
            }
        );

        $this->session->set('societe', json_encode($societe));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
