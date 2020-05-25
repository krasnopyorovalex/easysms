<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Post;
use App\Http\Transformers\PostTransformer;
use Psr\Http\Message\ServerRequestInterface;

class PostController extends AppController
{
    public function view(ServerRequestInterface $request): array
    {
        /** @var $post Post */
        $post = $this->em->getRepository(Post::class)
            ->find((int) $request->getAttribute('id'));

        return $this->item($post, new PostTransformer);
    }

    public function search(ServerRequestInterface $request): array
    {
        $queryParams = $request->getQueryParams();

        $posts = $this->em->getRepository(Post::class)
            ->findByTitle(filter_var($queryParams['title'], FILTER_SANITIZE_STRING));

        return $this->collection($posts, new PostTransformer);
    }
}
