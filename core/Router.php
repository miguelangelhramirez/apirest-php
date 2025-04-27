
<?php

require_once "core/Response.php";

class Router {
    public function run() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];

        $controllerName = ucfirst(strtolower($url[0] ?? "home")) . "Controller";
        $methodName = strtolower($url[1] ?? "index");

        $controllerPath = "controllers/" . $controllerName . ".php";

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerName;

            if (method_exists($controller, $methodName)) {
                $controller->{$methodName}();
            } else {
                Response::error("Método '$methodName' no encontrado en $controllerName", 404);
            }
        } else {
            Response::error("Controlador '$controllerName' no encontrado", 404);
        }
    }
}

