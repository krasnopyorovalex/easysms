<?php

declare(strict_types=1);

namespace App\Http\Transformers;

use App\Entities\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post): array
    {
        return [
            'title' => $post->getTitle(),
            'preview' => $post->getPreview(),
            'text' => $post->getText()
        ];
    }
}
