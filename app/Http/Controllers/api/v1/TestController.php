<?php

namespace App\Http\Controllers\Api\V1;

use App\Like;
use DB;
use Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request){
        $user = Auth::user();
        return response($user);
    }
}
