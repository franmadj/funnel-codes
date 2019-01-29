<?php

namespace App\Events;

use App\CouponBank;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class UpdateCoupons extends Event
{
    use SerializesModels;

    
    public $couponBank;

    /**
     * Create a new event instance.
     *
     * @param  Funnel  $funnel
     * @return void
     */
    public function __construct(CouponBank $couponBank)
    {
        $this->couponBank = $couponBank;
    }
}
