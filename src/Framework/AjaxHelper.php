<?php

namespace Metis\Framework;

class AjaxHelper
{
    public static function success(string $message= '', array $data= [])
    {
        $response= [
            'success' => !0,
            'message' => $message,
            'data' => $data
        ];

        echo json_encode($response); exit;
    }

    public static function fail(string $message, array $data= [])
    {
        $response= [
            'success' => !1,
            'message' => $message,
            'data' => $data
        ];

        echo json_encode($response); exit;
    }
}