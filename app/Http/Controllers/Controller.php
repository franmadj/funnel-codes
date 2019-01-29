<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected function validationErrorResponse(\Exception $e) {
        $messages=$e->getErrors()->getMessages();
        if($error=reset($messages)[0]){
            return $error;
        }
        return $e->getMessage();
        
    }

}
