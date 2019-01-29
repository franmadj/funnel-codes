<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;

class CouponField extends Model {

    protected $fillable = ['coupon_bank_id', 'name', 'description', 'field_type', 'required'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $rules = [
        'coupon_bank_id' => 'required|integer',
        'name' => 'required|string',
       
        'field_type' => 'required|string',
        'required' => 'required|boolean',

    ];

    public function couponBank() {
        return $this->belongsTo(couponBank::class);
    }

    /**
     * 
     * @param type $data
     * @param type $userOrId
     * @return \self
     */
    public static function make($data, $couponBankId) {
        $couponField = new self;
        $data = array_merge($data,[
            'coupon_bank_id' => $couponBankId,
        ]);
        $data['required']=$data['required']?true:false;
        
        self::validateData($data, $couponField);
        $couponField->fill(array_only($data, $couponField->fillable));
        $couponField->save();
        return $couponField;
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public static function updateCouponField(CouponField $couponField, $data) { //var_dump($couponField);exit;
        //$couponField = CouponField::findOrFail($id);
        unset($couponField->rules['coupon_bank_id']);
        $data['required']=$data['required']?true:false;
        self::validateData($data, $couponField);
        $couponField->fill(array_only($data, $couponField->fillable));
        $couponField->save();
        return $couponField;
    }


}
