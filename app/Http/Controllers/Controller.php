<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     ** Add custom error validation format.
     *  https://stackoverflow.com/questions/43649091/lumen-customize-validation-response
     *  https://lumen.laravel.com/docs/8.x/validation
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return response()->json([
            "message" => 'Your request is invalid.',
            "errors" => $errors
        ], 422);
    }
}
