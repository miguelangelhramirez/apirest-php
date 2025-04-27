
<?php
require_once "core/Response.php";
class Controller {
    public function model($model) {
        require_once "models/$model.php";
        return new $model();
    }

    public function view($data) {
        echo json_encode($data);
    }
}
