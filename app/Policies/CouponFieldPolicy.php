<?php

namespace App\Policies;

use App\CouponField;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponFieldPolicy {

    use HandlesAuthorization;

    public function before($user, $ability) {
//        if ($user->hasRole('admin')) {
//            return true;
//        }
    }

    public function view(User $user, CouponField $model) {
        return $model->couponBank->funnel->user->id==$user->id;
    }

    public function edit(User $user) {
        return true;
    }

    public function create(User $user) {
        return true;
    }

    public function update(User $user, CouponField $model) {
        return $model->couponBank->funnel->user->id==$user->id;
    }

    public function delete(User $user, CouponField $model) {
        return $model->couponBank->funnel->user->id==$user->id;
    }

}
