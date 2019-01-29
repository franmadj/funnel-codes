<?php

namespace App\Policies;

use App\Funnel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FunnelPolicy {

    use HandlesAuthorization;


    public function view(User $user, Funnel $model) {
        return $model->user->id==$user->id;
    }

    public function edit(User $user) {
        return true;
    }

    public function create(User $user) {
        return true;
    }

    public function update(User $user, Funnel $model) { 
        return $model->user->id==$user->id;
    }

    public function delete(User $user, Funnel $model) {
        return $model->user->id==$user->id;
    }

}
