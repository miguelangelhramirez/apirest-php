<?php

class UserDTO {
    public $email;
    public $nombre;
    public $password;
    public $cargo;
    public $rol;

    public function __construct(array $data) {
        $this->email = $data['email'] ?? null;
        $this->nombre = $data['nombre'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->cargo = $data['cargo'] ?? null;
        $this->rol = $data['rol'] ?? null;
    }

    public function isValid() {
        return $this->email && $this->nombre && $this->password && $this->cargo && $this->rol;
    }

    public function toArray() {
        return [
            "email" => $this->email,
            "nombre" => $this->nombre,
            "password" => $this->password,
            "cargo" => $this->cargo,
            "rol" => $this->rol,
        ];
    }
}
