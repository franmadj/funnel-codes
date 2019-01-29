<?php

namespace App\Policies;

use App\CouponCode;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponCodePolicy {

    use HandlesAuthorization;

    public function before($user, $ability) {
//        if ($user->hasRole('admin')) {
//            return true;
//        }
    }

    public function view(User $user, CouponCode $model) {
        return $model->couponBank->funnel->user->id==$user->id;
    }

    public function edit(User $user) {
        return true;
    }

    public function create(User $user) {
        return true;
    }

    public function update(User $user, CouponCode $model) {
        return $model->couponBank->funnel->user->id==$user->id;
    }

    public function delete(User $user, CouponCode $model) {
        return $model->couponBank->funnel->user->id==$user->id;
    }

}
