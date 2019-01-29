<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;

class Tag extends Model
{
    protected $fillable = ['user_id','name', 'color'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $rules = [
        'name' => 'required|string',
        'color' => 'required|string',
        'user_id' => 'required|integer',
    ];

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => 'A name is required.',
            'color.required'    => 'Please select a color.'
        ];
    }

    public function funnel() {
        return $this->belongsToMany(Tag::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    
    /**
     * 
     * @param type $data
     * @param type $userOrId
     * @return \self
     */

    public static function make($data, $userOrId) {
        $tag = new self;
        $data = array_merge($data, [
            'user_id' => get_object_id(User::class, $userOrId),
        ]);
        $data['color']=$data['color']['hex'];
        self::validateData($data, $tag);
        $tag->fill(array_only($data, ['user_id', 'name', 'color']));
        $tag->save();
        return $tag;
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public static function updateTag(Tag $tag, $data) { 
        //$tag = Tag::findOrFail($id);
        unset($tag->rules['user_id']);
        $data['color']=!empty($data['color']['hex'])?$data['color']['hex']:$data['color'];
        self::validateData($data, $tag);
        $tag->fill(array_only($data, ['name', 'color']));
        $tag->save();
        return $tag;
    }

}
