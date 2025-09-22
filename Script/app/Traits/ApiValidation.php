<?php

namespace App\Traits;

use App\Models\ApiClient;
use App\Models\User;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;

trait ApiValidation
{
    public $validationErrorStatus = 422;
    public $uncompletedErrorStatus = 423;
    public $unauthorizedErrorStatus = 403;
    public $notFoundErrorStatus = 404;
    public $invalidErrorStatus = 400;
    public $notAcceptableStatus = 406;
    public $unknownStatus = 419;

    public function validationErrors($error)
    {
        return ['message' => 'The given data was invalid.', 'error' => $error];
    }

    public function withErrors($error)
    {
        return ['status' => 'failed', 'message' => $error];
    }

    public function withSuccess($msg)
    {
        return ['status' => 'success', 'message' => $msg];
    }

    public function user($publicKey, $secretKey, $ip = null)
    {

        if (auth()->check()) {
            $user = auth()->user();
        }else{
            $user = User::where('public_key', $publicKey)->where('secret_key', $secretKey)->first();
        }
        return $user;
    }
}
