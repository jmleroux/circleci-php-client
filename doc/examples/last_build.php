#!/usr/bin/env php
<?php

declare(strict_types=1);

use Jmleroux\CircleCi\Api\BranchLastBuild;
use Jmleroux\CircleCi\Client;

require_once __DIR__.'/../../vendor/autoload.php';

$client = new Client('c900a267b73d8fbcab665fedc818c8de2b6aedf1');
$query = new BranchLastBuild($client);
$build = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master');

var_dump($build);
