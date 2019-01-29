<?php

namespace App;

use App\Model;
use App\Events\UpdateCoupons;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;

class CouponCode extends Model {

    protected $fillable = ['coupon_bank_id', 'code'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $rules = [
        'coupon_bank_id' => 'required|integer',
        'code' => 'required|string',
    ];

    public function couponBank() {
        return $this->belongsTo(CouponBank::class);
    }
    
    public function issetCouponCode($couponBankId, $code){
        $couponBanks = CouponBank::where('id',$couponBankId)->first()->funnel->couponBanks->pluck('id')->toArray();
        if (CouponCode::where('code', '=', $code)->whereIn('coupon_bank_id', $couponBanks)->exists()) {
            return true;
        }
        return false;
        
    }

    /**
     * 
     * @param type $data
     * @param type $userOrId
     * @return \self
     */
    public static function make($code, $couponBankId) {
        $couponCode = new self;
        if($couponCode->issetCouponCode($couponBankId, $code))
            return false;
        
        $data = [
            'coupon_bank_id' => $couponBankId,
            'code' => $code,
        ];
        self::validateData($data, $couponCode);
        $couponCode->fill(array_only($data, $couponCode->fillable));
        $couponCode->save();
        event(new UpdateCoupons($couponCode->couponBank));
        return $couponCode;
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public static function updateCouponCode(CouponCode $couponCode, $data) { //var_dump($couponCode);exit;
        if($couponCode->issetCouponCode($couponCode->coupon_bank_id, $data['code']))
            return false;
        unset($couponCode->rules['coupon_bank_id']);
        self::validateData($data, $couponCode);
        $couponCode->fill(array_only($data, $couponCode->fillable));
        $couponCode->save();
        return $couponCode;
    }

}
