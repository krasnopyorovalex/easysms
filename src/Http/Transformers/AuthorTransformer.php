<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use App\Entities\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    /**
     * @param Author $author
     * @return array
     */
    public function transform(Author $author): array
    {
        return [
            'fio' => $author->getFio(),
            'avatar' => $author->getAvatar(),
            'signature' => $author->getSignature()
        ];
    }
}
