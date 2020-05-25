<?php

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    (Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

    require dirname(__DIR__) . '/config/routes.php';

} catch (Exception $exception) {
    var_dump($exception);
}
