<?php

use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;

include('./vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sftp = new SFTP($_ENV['SSH_HOST'], $_ENV['SSH_PORT']);

if ($_ENV['SSH_KEYFILE']) {
    $key = new RSA();
    $key->setPassword($_ENV['SSH_PASSWORD']);
    $key->loadKey(file_get_contents($_ENV['SSH_KEYFILE']));
} else {
    $key = $_ENV['SSH_PASSWORD'];
}

if (!$sftp->login($_ENV['SSH_USERNAME'], $key)) {
    exit('Login Failed');
}

echo $sftp->pwd() . PHP_EOL;
