<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Watson\Validating\ValidatingTrait;
use Watson\Validating\ValidationException;

class Model extends BaseModel {

    use ValidatingTrait;
    
    protected $throwValidationExceptions = true;

    protected static function validateData($data, $model) {
        $validator = Validator::make($data, $model->rules);

        if ($validator->fails()) {
            throw new ValidationException($validator, $model);
        }
    }

}
