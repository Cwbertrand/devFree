<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\SocieteRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SocieteExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('societe', [SocieteRuntime::class, 'societe']),
        ];
    }
}
