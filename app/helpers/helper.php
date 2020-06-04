<?php
// Response function for api with json

function jsonResponse($status , $message , $data = null , $token = null){

    if ($data === null) {
        $response = [
            'status'    => $status ,
            'message'   => $message,
        ];
    } else {
        $response = [
            'status'    => $status ,
            'message'   => $message,
            'data'      => $data
        ];
    }
    if ($token) {
        $response = [
            'status'    => $status ,
            'message'   => $message,
            'data'      => $data ,
            'access_token'     => $token
        ];
    }
    if ($status == 0){
        $status = 400;
    } else {
        $status = 200;
    }

    return response()->json($response , $status);
}
