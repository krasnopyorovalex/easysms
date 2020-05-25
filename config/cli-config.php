<?php

declare(strict_types=1);

use App\Infrastructure\Database\Connection;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require dirname(__DIR__) . '/vendor/autoload.php';

try {
    (Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

    // replace with mechanism to retrieve EntityManager in your app
    $entityManager = Connection::create();

    return ConsoleRunner::createHelperSet($entityManager);
} catch (ORMException $exception) {
    var_dump($exception);
}
