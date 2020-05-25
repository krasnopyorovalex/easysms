<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Traits\DataManagerTrait;
use Doctrine\ORM\EntityManager;

class AppController
{
    use DataManagerTrait;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AuthorController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
