<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Author;
use App\Http\Transformers\AuthorTransformer;

class AuthorController extends AppController
{

    public function __invoke() : array
    {
        $authors = $this->em->getRepository(Author::class)
            ->findAll();

        return $this->collection($authors, new AuthorTransformer);
    }
}
