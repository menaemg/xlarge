<?php

namespace App\Http\Controllers\Api\V1\auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    protected function sendResetResponse(Request $request, $response)
    {
        $status = 1;
        $message = trans($response);

        return jsonResponse($status, $message);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        $status = 0;
        $message = trans($response);

        return jsonResponse($status, $message);
    }

}
