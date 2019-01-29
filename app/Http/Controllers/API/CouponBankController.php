<?php

namespace App\Http\Controllers\API;

use App\CouponBank;
use App\Funnel;
use Illuminate\Http\Request;
use App\Events\CouponBankCompleted;
use App\Http\Controllers\Controller;
use Flugg\Responder\Facades\Responder;
use App\Transformers\CouponBankTransformer;
use App\Events\UpdateCoupons;
use Watson\Validating\ValidationException;

class CouponBankController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Get all of the couponBank.
     *
     * @return Response
     */
    public function index($id, Request $request) {
        $limit=$request->has('limit')?$request->get('limit'):5;
        $couponBanks = CouponBank::where('funnel_id', $id)->paginate($limit);
        return Responder::success($couponBanks, new CouponBankTransformer)->respond();
    }
    
    public function show(CouponBank $couponBank){
        
        return Responder::success($couponBank, new CouponBankTransformer)->respond();    
    }

   

    /**
     * Create a new CouponBank.
     *
     * @return Response
     */
    public function store(Request $request, Funnel $funnel) { 
        try {
            $couponBank = CouponBank::make($request->all(), $funnel->id);
            return Responder::success($couponBank, new CouponBankTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }
    
    /**
     * Create a new CouponBank.
     *
     * @return Response
     */
    public function duplicate(CouponBank $couponBank) { 
        try {
            $couponBank = CouponBank::duplicate($couponBank);
            return Responder::success($couponBank, new CouponBankTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) { 
            return Responder::error($e->getMessage());
        }
    }

    /**
     * 
     * @param CouponBank $couponBank
     * @param Request $request
     * @return type
     */
    public function update(Request $request, CouponBank $couponBank) { //var_dump($);
        try {
            $couponBank=CouponBank::updateCouponBank($request->all(), $couponBank);
            return Responder::success($couponBank, new CouponBankTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * Destroy the given couponBank.
     *
     * @param  Request  $request
     * @param  CouponBank  $couponBank
     * @return Response
     */
    public function destroy(Request $request, CouponBank $couponBank) {
        

        try {
            event(new UpdateCoupons($couponBank, true));
            $result = $couponBank->delete();
            if ($result) {
                event(new UpdateCoupons($couponBank));
                return Responder::success();
            }

            return Responder::error('CouponBank was not deleted!');
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    public static function Routes() {

        \Route::group(['prefix' => 'couponBanks'], function () {
            \Route::get('{id}', 'API\CouponBankController@index');
            \Route::get('/show/{couponBank}', 'API\CouponBankController@show');
            \Route::post('{funnel}', 'API\CouponBankController@store');
            \Route::delete('{couponBank}', 'API\CouponBankController@destroy');
            \Route::post('/update/{couponBank}', 'API\CouponBankController@update');
        });
    }

}
