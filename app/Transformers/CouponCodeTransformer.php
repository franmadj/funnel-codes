<?php

namespace App\Transformers;

use App\CouponCode;
use Flugg\Responder\Transformers\Transformer;
use League\Fractal\ParamBag;

class CouponCodeTransformer extends Transformer {


    public function transform(CouponCode $couponCode): array {
        return [
            'id' => (int) $couponCode->id,
            'code' => $couponCode->code,
            'created_at' => $couponCode->created_at,
            'redeemed' => json_decode($couponCode->redeemed),
            
        ];
    }

}
