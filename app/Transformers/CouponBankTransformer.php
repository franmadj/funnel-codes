<?php

namespace App\Transformers;

use App\CouponBank;
use Flugg\Responder\Transformers\Transformer;
use League\Fractal\ParamBag;

class CouponBankTransformer extends Transformer {

    /**
     * A list of all available relations.
     *
     * @var array
     */
    protected $relations = ['couponCodes'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = ['couponCodes'];

    public function transform(CouponBank $couponBank): array {
        return [
            'id' => (int) $couponBank->id,
            'name' => $couponBank->name,
            'description' => $couponBank->description,
            'created_at' => $couponBank->created_at,
            'type' => $couponBank->type,
            'expires_at' => $couponBank->ends_at,
            'no_of_redeemed' => $couponBank->no_of_redeemed?:0,
            'no_of_coupons' => $couponBank->no_of_coupons?:0,
            'codes'=>$couponBank->couponCodes->pluck('code')
        ];
    }

}
