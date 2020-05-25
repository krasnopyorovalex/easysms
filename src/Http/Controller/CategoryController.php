<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Entities\Category;
use App\Http\Transformers\PostTransformer;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController extends AppController
{

    public function news(ServerRequestInterface $request) : array
    {
        /** @var $category Category */
        $category = $this->em->getRepository(Category::class)
            ->find((int) $request->getAttribute('id'));

        return $this->collection($category->getPosts(), new PostTransformer);
    }
}
