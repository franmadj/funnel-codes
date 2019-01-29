<?php

namespace App\Transformers;

use App\CouponField;
use Flugg\Responder\Transformers\Transformer;
use League\Fractal\ParamBag;

class CouponFieldTransformer extends Transformer {


    public function transform(CouponField $couponField): array {
        return [
            'id' => (int) $couponField->id,
            'name' => $couponField->name,
            'field_type' => $couponField->field_type,
            'validation_type' => $couponField->validation_type,
            'created_at' => $couponField->created_at,
            'description' => $couponField->description,
            'required' => $couponField->required,
            
        ];
    }

}
