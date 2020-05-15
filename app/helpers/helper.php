<?php
// Response function for api with json

function jsonResponse($status , $message , $data = null){

    $response = [
        'status'    => $status ,
        'message'   => $message,
        'data'      => $data
    ];

    return response()->json($response);
}
