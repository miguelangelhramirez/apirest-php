<?php

class Response {
    public static function success($data = [], $code = 200, $body = []) {
        http_response_code($code);
        echo json_encode([
            "success" => true,
            "status" => $code,
            "message" => $data,
            "body" => $body
        ]);
        exit;
    }

    public static function created($data = [], $code = 201, $body = []) {
        http_response_code($code);
        echo json_encode([
            "success" => true,
            "status" => $code,
            "message" => $data,
            "body" => $body
        ]);
        exit;
    }

    public static function badRequest($message = "Bad request", $code = 400, $body = []) {
        http_response_code($code);
        echo json_encode([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "body" => $body
            ]);
        exit;
    }

    public static function unauthorized($message = "Acceso no autorizado", $code = 401, $body = []) {
        http_response_code($code);
        echo json_encode([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "body" => $body
            ]);
        exit;
    }


    public static function error($message = "Error interno", $code = 500, $body = []) {
        http_response_code($code);
        echo json_encode([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "body" => $body
            ]);
        exit;
    }
}
