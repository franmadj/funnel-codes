<?php

namespace App\Listeners;

use App\Events\UpdateCoupons;

class SetCoupons {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateCoupons  $event
     * @return void
     */
    public function handle(UpdateCoupons $event) {
        $couponBank = $event->couponBank;
        $codesCountByBank = $this->countCodes($couponBank);
        $couponBank->no_of_coupons = $codesCountByBank['numCodes'];
        $couponBank->no_of_redeemed = $codesCountByBank['numRedeemed'];
        $couponBank->save();

        $funnel = $couponBank->funnel;
        $couponBanks = $funnel->couponBanks;
        $codesCountByBank=0;
        $redeemedCountByBank=0;
        $collection = $couponBanks->each(function ($item, $key) use (&$codesCountByBank, &$redeemedCountByBank) {
            $codesCountByBank+=$this->countCodes($item)['numCodes'];
            $redeemedCountByBank+=$this->countCodes($item)['numRedeemed'];
        });
        $funnel->no_of_coupons=$codesCountByBank;
        $funnel->no_of_redeemed=$redeemedCountByBank;
        $funnel->save();

    }

    /**
     * 
     * @param type $couponBank
     * @return type
     */
    private function countCodes($couponBank) { 
        $redeemed=0;
        $couponBank->couponCodes->each(function($el)use(&$redeemed){
            if($el->redeemed){
                $redeemed++;
            }
        });
        return ['numCodes'=>$couponBank->couponCodes->count(),'numRedeemed'=>$redeemed];
    }

}
