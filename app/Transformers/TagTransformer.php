<?php

namespace App\Transformers;

use App\Tag;
use Flugg\Responder\Transformers\Transformer;
use League\Fractal\ParamBag;

class TagTransformer extends Transformer {

    public function transform(Tag $tag): array {
        return [
            'id' => (int) $tag->id,
            'name' => $tag->name,
            'user' => [
                'name' => $tag->user->name,
                'id' => (int) $tag->user->id
            ],
            'color' => $tag->color,
            'created_at' => $tag->created_at,
        ];
    }

}
