<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SocieteRuntime implements RuntimeExtensionInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function societe(string $key, string $option): string
    {
        $societe = json_decode($this->requestStack->getSession()->get('societe'));

        return empty($societe) ? '' : $societe->$key->tabs->$option->value;
    }

    public function get(string $key, string $option): string
    {
        return $this->societe($key, $option);
    }
}
