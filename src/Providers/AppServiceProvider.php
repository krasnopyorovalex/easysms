<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controller\AuthorController;
use App\Http\Controller\CategoryController;
use App\Http\Controller\PostController;
use App\Infrastructure\Database\Connection;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        EntityManager::class,
        PostController::class,
        AuthorController::class,
        CategoryController::class
    ];

    public function register()
    {
        $this->getContainer()->add(EntityManager::class, function () {
            return Connection::create();
        }, true);

        $this->getContainer()
            ->add(PostController::class)
            ->addArgument(EntityManager::class);

        $this->getContainer()
            ->add(AuthorController::class)
            ->addArgument(EntityManager::class);

        $this->getContainer()
            ->add(CategoryController::class)
            ->addArgument(EntityManager::class);
    }
}
