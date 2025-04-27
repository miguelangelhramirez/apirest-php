
<?php
require_once "../core/Controller.php";

class RoleController extends Controller {
    public function index() {
        $model = $this->model("Role");
        $this->view($model->getAll());
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID requerido"]);
            return;
        }

        $model = $this->model("Role");
        $this->view($model->getById($id));
    }
}
