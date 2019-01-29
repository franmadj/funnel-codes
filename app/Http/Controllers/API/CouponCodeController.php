<?php

namespace App\Http\Controllers\API;

use App\CouponCode;
use App\CouponBank;
use Illuminate\Http\Request;
use App\Events\CouponCodeCompleted;
use App\Http\Controllers\Controller;
use Flugg\Responder\Facades\Responder;
use App\Transformers\CouponCodeTransformer;
use App\Events\UpdateCoupons;
use Watson\Validating\ValidationException;

class CouponCodeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Get all of the couponCode.
     *
     * @return Response
     */
    public function index($id, Request $request) {
        $couponCodes = CouponCode::where('coupon_bank_id', $id);
        if ($request->has('type')) {
            if ($request->get('type') == 'redeemed') {
                $couponCodes = $couponCodes->whereNotNull('redeemed');
            } elseif ($request->get('type') == 'noRedeemed') {
                $couponCodes = $couponCodes->whereNull('redeemed');
            }
        }
        $limit = $request->has('limit') ? $request->get('limit') : 5;
        $couponCodes = $couponCodes->paginate($limit);
        return Responder::success($couponCodes, new CouponCodeTransformer)
                        ->respond();
    }

    /**
     * Create a new CouponCode.
     *
     * @return Response
     */
    public function store(Request $request, CouponBank $couponBank) {
        try {
            $couponCodes = [];

            if ($request->has('code') && $codes = array_map('trim', explode(',', $request->get('code')))) {
                foreach ($codes as $code) {
                    if ($result = CouponCode::make($code, $couponBank->id))
                        $couponCodes[] = $result->id;
                }
            }
            return Responder::success(CouponCode::whereIn('id', $couponCodes), new CouponCodeTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * 
     * @param CouponCode $couponCode
     * @param Request $request
     * @return type
     */
    public function update(Request $request, CouponCode $couponCode) {
        try {
            $couponCode = CouponCode::updateCouponCode($couponCode, $request->all());
            if (!$couponCode)
                return Responder::success();

            return Responder::success($couponCode, new CouponCodeTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * Destroy the given couponCode.
     *
     * @param  Request  $request
     * @param  CouponCode  $couponCode
     * @return Response
     */
    public function destroy(Request $request, CouponCode $couponCode) {

        try {

            $couponBank = $couponCode->couponBank;
            $result = $couponCode->forceDelete();
            if ($result) {
                event(new UpdateCoupons($couponBank));
                return Responder::success();
            }
            return Responder::error('CouponCode was not deleted!');
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    public function getCode(Request $request, couponBank $couponBank) {
        $validations = '';
        collect($request->all())->each(function($el)use(&$validations) {
            $validation = new \stdClass();
            $validation->{$el['key']} = $el['value'];
            $coma = '';

            $search = '{"' . $el['key'] . '": "' . $el['value'] . '"}'; //var_dump(json_encode($validation));
            $search = json_encode($validation); //var_dump(CouponCode::where('redeemed', '@>', $search)->exists());return;
            if ($couponCode = CouponCode::where('redeemed', '@>', $search)->exists()) {
                $validations=false;

                
            } else {
                $validations .= $coma . $search;
                $coma = ',';
            }
        });
        if ($validations===false) {
            return Responder::error('Data already in used!');
            
        }else if ($validations) {
            $code = $couponBank->couponCodes->where('redeemed', null)->first();
            //var_dump($code);
            if ($code) {
                $code->redeemed = $validations;
                $code->save();
                event(new UpdateCoupons($couponBank));
                return Responder::success($code, new CouponCodeTransformer)->respond();
            } else {
                return Responder::error('No Coupons left!');
            }
        } else {
            return Responder::error('No validation provided!');
        }
    }

    public static function Routes() {

        \Route::group(['prefix' => 'couponCodes'], function () {
            \Route::get('{id}', 'API\CouponCodeController@index');
            \Route::post('{couponBank}', 'API\CouponCodeController@store');
            \Route::delete('{couponCode}', 'API\CouponCodeController@destroy');
            \Route::post('/update/{couponCode}', 'API\CouponCodeController@update');
            \Route::post('/getCode/{couponBank}', 'API\CouponCodeController@getCode');
        });
    }

}
