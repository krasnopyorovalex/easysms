<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Traits\DataManagerTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AppController
{
    use DataManagerTrait;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * AuthorController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
