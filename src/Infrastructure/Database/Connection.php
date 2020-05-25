<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Connection
{
    private function __construct()
    {
    }

    /**
     * @return EntityManager
     * @throws ORMException
     */
    public static function create(): EntityManager
    {
        $paths = [dirname(__DIR__) . '/../../src/Entities'];

        $isDevMode = getenv('DEV_MODE');

        // the connection configuration
        $dbParams = [
            'driver'   => 'pdo_' . getenv('DB_DRIVER'),
            'user'     => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'dbname'   => getenv('DB_NAME'),
            'charset'  => getenv('DB_CHARSET'),
            'profiler' => false
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $config->setProxyDir(dirname(__DIR__) . '/../../build//Proxies');
        $config->setProxyNamespace('EasySms\Proxies');

        return EntityManager::create($dbParams, $config);
    }
}
