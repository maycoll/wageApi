<?php


function fg_response(bool $success, array $data, String $message, int $code){
    return response()->json([
        'success' => $success,
        'data'    => $data,
        'message' => $message,
    ],
        $code);
}

function fg_responsePage(bool $success, array $data, int $current_page, int $last_page, int $per_page, int $total, String $message, int $code){
    return response()->json([
        'success'      => $success,
        'current_page' => $current_page,
        'last_page'    => $last_page,
        'per_page'     => $per_page,
        'total'        => $total,
        'data'         => $data,
        'message'      => $message,
    ],
        $code);
}

function fg_responseStr(bool $success, String $data, String $message, int $code){
    return response()->json([
        'success' => $success,
        'data'    => $data,
        'message' => $message,
    ],
        $code);
}

?>