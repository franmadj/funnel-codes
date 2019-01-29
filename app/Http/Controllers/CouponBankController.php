<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funnel;
use App\CouponBank;

class CouponBankController extends Controller {

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
    public function index(Funnel $funnel) {
        return view('coupons.index', ['data' => $funnel->getAttributes()]);
    }

    public function redemption(CouponBank $couponBank) {
        $validations = $couponBank->couponFields;
        $funnel = $couponBank->funnel;



        return view('coupons.redemption', ['validations' => $validations, 'funnel' => $funnel, 'couponBank' => $couponBank]);
    }

}
