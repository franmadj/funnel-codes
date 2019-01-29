<?php

namespace App\Transformers;

use App\Funnel;
use Flugg\Responder\Transformers\Transformer;
use League\Fractal\ParamBag;

class FunnelTransformer extends Transformer {

    /**
     * A list of all available relations.
     *
     * @var array
     */
    protected $relations = ['tags'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = ['tags'];

    public function transform(Funnel $funnel): array {
        return [
            'id' => (int) $funnel->id,
            'name' => $funnel->name,
            'user' => [
                'name' => $funnel->user->name,
                'id' => (int) $funnel->user->id
            ],
            
            'description' => $funnel->description,
            'created_at' => $funnel->created_at,
            'starts_at' => $funnel->starts_at,
            'ends_at' => $funnel->ends_at,
            'no_of_redeemed' => $funnel->no_of_redeemed?:0,
            'no_of_coupon' => $funnel->no_of_coupons?:0,
        ];
    }

}
