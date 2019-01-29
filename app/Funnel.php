<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;


class Funnel extends Model {
    
    protected $fillable = ['user_id', 'name', 'description', 'starts_at', 'ends_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'starts_at', 'ends_at'];
    
    public $rules = [
        'name' => 'required|max:255',
        
        'starts_at' => 'required|date',
        'ends_at' => 'required|date',
        'user_id' => 'required|integer',
    ];




    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function couponBanks() {
        return $this->hasMany(CouponBank::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function addTags(array $tags) {
        $this->tags()->detach();
        return $this->tags()->attach($tags);
    }

    /**
     * 
     * @param type $data
     * @param type $userOrId
     * @return \self
     */
    public static function make($data, $userOrId) {
        $funnel = new self;
        $data = array_merge($data, [
            'user_id' => get_object_id(User::class, $userOrId),
        ]);
        self::validateData($data, $funnel);
        $funnel->fill(array_only($data, ['user_id', 'name', 'description', 'starts_at', 'ends_at'])); 
        $funnel->save();
        $funnel->addTags(array_get($data, 'tags', []));
        return $funnel;
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public static function updateFunnel(Funnel $funnel, $data) { //var_dump($funnel);exit;
        //$funnel = Funnel::findOrFail($id);
        unset($funnel->rules['user_id']);

        self::validateData($data, $funnel);
        $funnel->fill(array_only($data, ['name', 'description', 'starts_at', 'ends_at']));
        $funnel->save();
        $funnel->addTags(array_get($data, 'tags', []));
        return $funnel;
    }

    

}
