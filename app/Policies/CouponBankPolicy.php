<?php

namespace App\Policies;

use App\CouponBank;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponBankPolicy {

    use HandlesAuthorization;

    public function before($user, $ability) {
//        if ($user->hasRole('admin')) {
//            return true;
//        }
    }

    public function view(User $user, CouponBank $model) {
        return $model->funnel->user->id==$user->id;
    }

    public function edit(User $user) {
        return true;
    }

    public function create(User $user) {
        return true;
    }

    public function update(User $user, CouponBank $model) {
        return $model->funnel->user->id==$user->id;
    }

    public function delete(User $user, CouponBank $model) {
        return $model->funnel->user->id==$user->id;
    }

}
