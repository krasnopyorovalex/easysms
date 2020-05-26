<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Author;
use App\Http\Transformers\AuthorTransformer;
use App\Http\Transformers\PostTransformer;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;

class AuthorController extends AppController
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->repository = $this->em->getRepository(Author::class);
    }

    public function index(): array
    {
        $authors = $this->repository->findAll();

        return $this->collection($authors, new AuthorTransformer);
    }

    public function news(ServerRequestInterface $request): array
    {
        $author = $this->repository->find((int) $request->getAttribute('id'));

        return $this->collection($author->getPosts(), new PostTransformer);
    }
}
