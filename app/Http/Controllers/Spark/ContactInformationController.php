<?php

namespace App\Http\Controllers\Spark;


use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\CouponBankCompleted;
use Flugg\Responder\Facades\Responder;



class ContactInformationController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * 
     * @param Request $request
     * @param User $user
     * @return type
     */
    public function update(Request $request, User $user) { //var_dump($request->user()->id);
        try {
            $user=User::updateUser($request->all(), $request->user());
            return Responder::success()->respond();
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }
    
    

}
