<?php

namespace App;

use Laravel\Spark\User as SparkUser;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;
use App\Events\UpdateCoupons;

class User extends SparkUser {
    
    protected $rules = [
        'email' => 'required|email',
        'name' => 'required|string',
        
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function funnels() {
        return $this->hasMany(Funnel::class)->orderBy('created_at', 'asc');
    }

    public function tags() {
        return $this->hasMany(Tag::class)->orderBy('created_at', 'asc');
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public static function updateUser($data, User $user) {
        //$user = User::findOrFail($id);
        //unset($user->rules['funnel_id']); 
        //var_dump($user);exit;

        self::validateData($data, $user);
        $user->fill(array_only($data, $user->fillable));
        $user->save();
        
        return $user;
    }

    private static function validateData($data, $user) {
        $validator = Validator::make($data, $user->rules);

        if ($validator->fails()) {
            throw new ValidationException($validator, $user);
        }
    }

}
