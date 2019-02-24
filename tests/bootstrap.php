<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
if (is_file(__DIR__ . '/../.env.local')) {
    $dotenv->load(__DIR__ . '/../.env.local');
}
