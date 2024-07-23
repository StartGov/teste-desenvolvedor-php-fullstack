<?php

namespace App\Http\Controllers;

abstract class Controller
{
    const ERROR = 'Error';
    const SUCCESS = 'Success';
    public static function mensager($status, $exceptionMensager)
    {
        return response()->json([
            "status" => $status,
            "dates" => $exceptionMensager
        ]);
    }
}
