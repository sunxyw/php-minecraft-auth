<?php

require_once __DIR__ . '/vendor/autoload.php';

$auth = new \MinecraftAuth\MinecraftAuth();
$auth->setProvider('nide8');
$auth = $auth->getInstance();

$auth->setServerId('8c913a1a8a8f11e9921b525400b59b6a');
$a = $auth->authenticate([
    'agent' => [
        'name' => 'Minecraft',
        'version' => 1,
    ],
    'username' => 'sunxyw',
    'password' => 'x1u3l1e7x8i2'
]);
$b = $auth->refresh($a['accessToken']);
$c = $auth->validate($b['accessToken']);

dump($a, $b, $c);