<?php

namespace MinecraftAuth\Providers;

interface iProvider
{
    public function setClientToken($client_token);
    public function authenticate(array $data);
    public function refresh($access_token, $options = []);
    public function validate($access_token);
    public function logout(array $data);
    public function invalidate($access_token);
}