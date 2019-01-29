<?php

namespace Laravel\Spark\Interactions\Settings\Profile;

use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Events\Profile\ContactInformationUpdated;
use Laravel\Spark\Contracts\Interactions\Settings\Profile\UpdateContactInformation as Contract;

class UpdateContactInformation implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function validator($user, array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handle($user, array $data)
    {
        $user->forceFill([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ])->save();

        event(new ContactInformationUpdated($user));

        return $user;
    }
}
