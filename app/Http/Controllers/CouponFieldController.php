<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponFieldController extends Controller {

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
        return view('coupons.fields', ['coupon_bank_id' => $couponBank->id]);
    }

}
