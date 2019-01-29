<?php

namespace App\Http\Controllers\API;

use App\CouponField;
use App\CouponBank;
use Illuminate\Http\Request;
use App\Events\CouponFieldCompleted;
use App\Http\Controllers\Controller;
use Flugg\Responder\Facades\Responder;
use App\Transformers\CouponFieldTransformer;
use App\Events\UpdateCoupons;
use Watson\Validating\ValidationException;

class CouponFieldController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Get all of the couponField.
     *
     * @return Response
     */
    public function index(Request $request, $id) {
        $limit=$request->has('limit')?$request->get('limit'):5;
        $couponFields = CouponField::where('coupon_bank_id', $id)->paginate($limit);

        return Responder::success($couponFields, new CouponFieldTransformer)
                        ->respond();
    }

    /**
     * Create a new CouponField.
     *
     * @return Response
     */
    public function store(Request $request, CouponBank $couponBank) { 
        try {
            $couponField=CouponField::make($request->all(), $couponBank->id);  
            return Responder::success($couponField, new CouponFieldTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }


    /**
     * 
     * @param CouponField $couponField
     * @param Request $request
     * @return type
     */
    public function update(Request $request, CouponField $couponField) {
        try {
            $couponField = CouponField::updateCouponField($couponField,$request->all());
            return Responder::success($couponField, new CouponFieldTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * Destroy the given couponField.
     *
     * @param  Request  $request
     * @param  CouponField  $couponField
     * @return Response
     */
    public function destroy(Request $request, CouponField $couponField) {

        try {
            
            $couponBank=$couponField->couponBank;
            $result = $couponField->forceDelete();
            if ($result) {
                event(new UpdateCoupons($couponBank));
                return Responder::success();
            }
            return Responder::error('CouponField was not deleted!');
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    public static function Routes() {

        \Route::group(['prefix' => 'couponFields'], function () {
            \Route::get('{id}', 'API\CouponFieldController@index');
            \Route::post('{couponBank}', 'API\CouponFieldController@store');
            \Route::delete('{couponField}', 'API\CouponFieldController@destroy');
            \Route::post('/update/{couponField}', 'API\CouponFieldController@update');
        });
    }

}
