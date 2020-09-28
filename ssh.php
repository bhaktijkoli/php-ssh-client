<?php

use phpseclib\Net\SSH2;
use phpseclib\Crypt\RSA;

include('./vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$ssh = new SSH2($_ENV['SSH_HOST'], $_ENV['SSH_PORT']);

if ($_ENV['SSH_KEYFILE']) {
    $key = new RSA();
    $key->setPassword($_ENV['SSH_PASSWORD']);
    $key->loadKey(file_get_contents($_ENV['SSH_KEYFILE']));
} else {
    $key = $_ENV['SSH_PASSWORD'];
}

if (!$ssh->login($_ENV['SSH_USERNAME'], $key)) {
    exit('Login Failed');
}

echo $ssh->read('username@username:~$');
$ssh->write("ping 8.8.8.8\n"); // note the "\n"
echo $ssh->read('username@username:~$');
