<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\ConfigurationRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ConfigurationExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('configuration', [ConfigurationRuntime::class, 'configuration']),
        ];
    }
}

