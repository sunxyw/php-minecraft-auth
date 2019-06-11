<?php

namespace MinecraftAuth;

use MinecraftAuth\Providers\iProvider;

class MinecraftAuth
{
    protected $provider = 'mojang';
    protected $availableProviders = [
        'mojang' => '',
        'nide8' => 'Nide8Provider'
    ];

    public function setProvider($provider)
    {
        if (array_key_exists($provider, $this->availableProviders)) {
            $this->provider = $this->availableProviders[$provider];
        } else {
            return false;
        }
    }

    public function getInstance(): iProvider
    {
        $provider = 'MinecraftAuth\Providers\\' . $this->provider;
        if (class_exists($provider)) {
            return new $provider;
        } else {
            die("Provider [$this->provider] not exist.");
        }
    }
}