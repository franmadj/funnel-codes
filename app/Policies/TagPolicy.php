<?php

namespace App\Policies;

use App\Tag;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy {

    use HandlesAuthorization;

    

    public function view(User $user, Tag $model) {
        return $model->user->id==$user->id;
    }

    public function edit(User $user) {
        return true;
    }

    public function create(User $user) {
        return true;
    }

    public function update(User $user, Tag $model) {
        return $model->user->id==$user->id;
    }

    public function delete(User $user, Tag $model) {
        return $model->user->id==$user->id;
    }

}
