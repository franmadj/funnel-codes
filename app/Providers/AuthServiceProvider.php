<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Funnel;
use App\Policies\FunnelPolicy;
use App\Tag;
use App\Policies\TagPolicy;
use App\CouponBank;
use App\Policies\CouponBankPolicy;
use App\CouponCode;
use App\Policies\CouponCodePolicy;
use App\CouponField;
use App\Policies\CouponFieldPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Funnel::class => FunnelPolicy::class,
        Tag::class => TagPolicy::class,
        CouponBank::class => CouponBankPolicy::class,
        CouponCode::class => CouponCodePolicy::class,
        CouponField::class => CouponFieldPolicy::class,
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
