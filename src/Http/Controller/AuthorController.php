<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Author;
use App\Http\Transformers\AuthorTransformer;
use Doctrine\ORM\EntityManager;

class AuthorController extends AppController
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->repository = $this->em->getRepository(Author::class);
    }

    public function __invoke() : array
    {
        $authors = $this->repository->findAll();

        return $this->collection($authors, new AuthorTransformer);
    }
}
