<?php 
function responseJson($status , $message , $data = []) 
{
    $response = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];

    return response()->json($response , 200);
}