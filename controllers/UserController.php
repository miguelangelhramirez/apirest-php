
<?php
require_once "core/Controller.php";
require_once "utils/functions.php";
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class UserController extends Controller {
    public function index() {
        $model = $this->model("User");
        $this->view($model->getAll());
    }

    public function show() {


        if($_SERVER['REQUEST_METHOD'] != "GET") {
            return Response::error("Bad request", 400, ["error" => "Metodo HTTP no permitido"]);
        }



        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo Response::error("Bad request", 400);
            return;
        }

        $model = $this->model("User");
        $this->view($model->getById($id));
    }

    public function store() {

        try {

            $headers = getallheaders();
            if (!isset($headers['Authorization'])) {
                return Response::unauthorized();
            }
            
            $jwt = getAuthToken($headers['Authorization']);

            try {

                $validatedDecodedJWT = validateToken($jwt, $_ENV["JWT_SECRETKEY"]);

            } catch (Exception $e) {

                return Response::unauthorized("Token inválido o expirado", 401, ["error" => $e->getMessage()]);

            }

            
            if($_SERVER['REQUEST_METHOD'] != "POST") {
                return Response::error("Bad request", 400, ["error" => "Metodo HTTP no permitido"]);
            }


            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['email'], $data['nombre'], $data['password'], $data['cargo'], $data['rol'])) {
                echo Response::error("Bad request", 400, ["error" => "Todos los datos son obligatorios"]);
                return;
            }

            $model = $this->model("User");
            $success = $model->create($data);

            if(!$success) {
                echo Response::error("Error al crear el usuario", 500);
            }
            echo Response::created("Dato creado",201,["id" => $success]);

        return;

        } catch (Exception $e) {
            Response::error("Error al crear el usuario", 500, ["error"=>$e->getMessage()]);
        }
        
        
    }

    public function update() {

        if($_SERVER['REQUEST_METHOD'] != "POST") {
            return Response::error("Bad request", 400, ["error" => "Metodo HTTP no permitido"]);
        }

        $id = $_GET['id'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$id || !isset($data['email'], $data['nombre'], $data['password'], $data['cargo'], $data['rol'])) {
            echo Response::error("Bad request", 400);
            return;
        }

        $model = $this->model("User");
        $success = $model->update($id, $data);
        echo Response::success("Dato actualizado");
    }

    public function delete() {

        if($_SERVER['REQUEST_METHOD'] != "POST") {
            return Response::error("Bad request", 400, ["error" => "Metodo HTTP no permitido"]);
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo Response::error("Bad request", 400);
            return;
        }

        $model = $this->model("User");
        $success = $model->delete($id);
        echo Response::success("Dato eliminado");
    }
}
