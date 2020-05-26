<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Category;
use App\Http\Transformers\PostTransformer;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController extends AppController
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->repository = $this->em->getRepository(Category::class);
    }

    public function news(ServerRequestInterface $request) : array
    {
        /** @var $category Category */
        $category = $this->repository->find(
            (int) $request->getAttribute('id')
        );

        return $this->collection($category->getPosts(), new PostTransformer);
    }

    public function search(ServerRequestInterface $request): array
    {
        $queryParams = $request->getQueryParams();

        $posts = $this->repository->searchByCategoryIdAndPostTitle(
            (int) $request->getAttribute('id'),
            filter_var($queryParams['keyword'], FILTER_SANITIZE_STRING),
            filter_var($queryParams['with-child'], FILTER_VALIDATE_BOOLEAN)
        );

        return $this->collection($posts, new PostTransformer);
    }
}
