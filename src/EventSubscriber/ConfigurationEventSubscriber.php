<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConfigurationEventSubscriber implements EventSubscriberInterface
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
        $this->file = $params->get('app_root').'/config/configuration.yaml';
        $this->cache = $cache;
        $this->session = $requestStack->getSession();
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        //if ($this->session->get('configuration') === null) {
        //$this->cache->delete('configuration');
        $configuration = $this->cache->get(
            'configuration',
            function (ItemInterface $item) {
                $item->expiresAfter(31536000); // 1an (60*60*24*365)

                return \file_exists($this->file) ? Yaml::parseFile($this->file) : [];
            }
        );

        $this->session->set('configuration', json_encode($configuration));
        //}
    }

    /**
     * Enregistrement du KernelEvents.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
