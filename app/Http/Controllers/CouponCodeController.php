<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CouponBank;
use App\CouponCode;

class CouponCodeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CouponBank $couponBank) {
        $funnel = $couponBank->funnel;
        return view('coupons.codes', ['coupon_bank_id' => $couponBank->id, 'funnelId' => $funnel->id, 'funnelName' => $funnel->name, 'bankName' => $couponBank->name]);
    }

    public function redeemed(CouponBank $couponBank) {
        return view('coupons.redeemed', ['coupon_bank_id' => $couponBank->id]);
    }

    public function fields(CouponBank $couponBank) {
        $funnel = $couponBank->funnel;
        return view('coupons.fields', ['coupon_bank_id' => $couponBank->id, 'funnelId' => $funnel->id, 'bankName' => $couponBank->name]);
    }

    public function export(CouponBank $couponBank) {
        $redemptions = CouponCode::where('coupon_bank_id', $couponBank->id)->whereNotNull('redeemed')->get();
        $result=[];
        $redemptions->each(function($e) use (&$result){
            $result[]=['code'=>$e['code'], 'redemption'=>json_decode($e['redeemed'])];   
        });
        $fileName = 'redemptions.json';
        \File::put(public_path('/upload/' . $fileName), collect($result)->toJson());
        return \Response::download(public_path('/upload/' . $fileName));
    }
    
    

}
