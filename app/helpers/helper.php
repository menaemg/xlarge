<?php
// Response function for api with json

function jsonResponse($status , $message , $data = null , $token = null){
    if ($token) {
        $response = [
            'status'    => $status ,
            'message'   => $message,
            'data'      => $data ,
            'access_token'     => $token
        ];
    }
    else {
        $response = [
            'status'    => $status ,
            'message'   => $message,
            'data'      => $data
        ];
    }
    if ($status == 0){
        $status = 400;
    } else {
        $status = 200;
    }

    return response()->json($response , $status);
}
