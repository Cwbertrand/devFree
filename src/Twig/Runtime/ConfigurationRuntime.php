<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConfigurationRuntime implements RuntimeExtensionInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function configuration(string $key, string $option): string
    {
        $configuration = json_decode($this->requestStack->getSession()->get('configuration'));

        return empty($configuration) ? '' : $configuration->$key->tabs->$option->value;
    }

    public function get(string $key, string $option): string
    {
        return $this->configuration($key, $option);
    }
}

