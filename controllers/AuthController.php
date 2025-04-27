<?php
require_once "core/Controller.php";
require_once "models/User.php";
require_once "utils/functions.php";
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller {

    public function login() {

        if($_SERVER['REQUEST_METHOD'] != "POST") {
            return Response::error("Bad request", 400, ["error" => "Metodo HTTP no permitido"]);
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['email'], $data['password'])) {
            echo Response::error("Bad request", 400);
            return;
        }
        $user = new User(); 
        $findUser =  $user->getByEmail($data['email']);

        if (!$findUser || !password_verify($data['password'], $findUser['password'])) {
            echo Response::error("Error al crear el usuario", 400);
            return;
        }

        $payload = [
            'userId' => $findUser['id'],
            'userEmail' => $findUser['email'],
            'userRol' => $findUser['rol'],
            'exp' => time() + 3600,
        ];

        $jwt = JWT::encode($payload, $_ENV["JWT_SECRETKEY"], 'HS256');

        try {

            $user->setToken($findUser['id'], $jwt);
            echo Response::success("Usuario autenticado exitosamente", 200, ["token" => $jwt]);
            return;

        } catch (\Throwable $th) {

            echo Response::error("Error al generar el token", 500, ["error" => $th]);
            
        }
        
    }

}

?>