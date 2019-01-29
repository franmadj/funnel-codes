<?php

namespace App;

use App\Model;
use App\Events\UpdateCoupons;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;

class CouponBank extends Model {

    protected $fillable = ['funnel_id', 'name', 'no_of_coupon', 'type', 'description'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $rules = [
        'funnel_id' => 'required|integer',
        'name' => 'required|string',
        'type' => 'required|string',
    ];

    public function funnel() {
        return $this->belongsTo(Funnel::class);
    }

    public function couponCodes() {
        return $this->hasMany(CouponCode::class, 'coupon_bank_id');
    }

    public function couponFields() {
        return $this->hasMany(couponField::class);
    }

    /**
     * 
     * @param type $codes
     */
    public function addCodes($codes) {
        $this->couponCodes()->delete();
        if (!empty($codes) && is_string($codes)) {
            if ($codes = array_map('trim', explode(',', $codes))) {
                $couponBanks=$this->funnel->couponBanks->pluck('id')->toArray();
                foreach ($codes as $code) {
                    if (CouponCode::where('code', '=', $code)->whereIn('coupon_bank_id',$couponBanks)->exists()) {
                        continue;
                    }
                    CouponCode::create(['code' => $code, 'coupon_bank_id' => $this->id]);
                }
            }
        }
    }



    /**
     * 
     * @param type $data
     * @param type $userOrId
     * @return \self
     */
    public static function make($data, $funnel_id) {
        $couponBank = new self;
        $data = array_merge($data, [
            'funnel_id' => $funnel_id,
        ]);

        self::validateData($data, $couponBank);
        $couponBank->fill(array_only($data, $couponBank->fillable));
        $couponBank->save();
        $couponBank->addCodes(array_get($data, 'codes', []));
        event(new UpdateCoupons($couponBank));
        return $couponBank;
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public static function updateCouponBank($data, CouponBank $couponBank) {
        //$couponBank = CouponBank::findOrFail($id);
        unset($couponBank->rules['funnel_id']);

        self::validateData($data, $couponBank);
        $couponBank->fill(array_only($data, $couponBank->fillable));
        $couponBank->save();
        $couponBank->addCodes(array_get($data, 'codes', []));
        event(new UpdateCoupons($couponBank));
        return $couponBank;
    }

}
