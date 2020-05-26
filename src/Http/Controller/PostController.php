<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Post;
use App\Http\Transformers\PostTransformer;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;

class PostController extends AppController
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->repository = $this->em->getRepository(Post::class);
    }

    public function view(ServerRequestInterface $request): array
    {
        /** @var $post Post */
        $post = $this->repository->find(
            (int) $request->getAttribute('id')
        );

        return $this->item($post, new PostTransformer);
    }

    public function search(ServerRequestInterface $request): array
    {
        $queryParams = $request->getQueryParams();

        $posts = $this->repository->searchByTitle(
            filter_var($queryParams['keyword'], FILTER_SANITIZE_STRING)
        );

        return $this->collection($posts, new PostTransformer);
    }
}
