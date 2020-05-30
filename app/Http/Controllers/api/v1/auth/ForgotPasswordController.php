<?php

namespace App\Http\Controllers\Api\V1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function sendResetLinkResponse(Request $request, $response)
    {
        $status = 1;
        $message = trans($response);

        return jsonResponse($status, $message);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $status = 0;
        $message = trans($response);
        return jsonResponse($status, $message);
    }
}
