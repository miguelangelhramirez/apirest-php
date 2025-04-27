<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getAuthToken($bearer) {
    $authorizationHeader = $bearer;
                
    $parts = explode(" ", $authorizationHeader);
                
    if (count($parts) === 2 && $parts[0] === "Bearer") {
        $bearerToken = $parts[1];
        return $bearerToken;
    }
    return false;
}

function validateToken($jwtToken, $jwtKey) {

    try {
        $decoded = JWT::decode($jwtToken, new Key($jwtKey, 'HS256'));
        return $decoded;
    } catch (ExpiredException $e) {
        throw new Exception("Token expirado", 1);
        
    } catch (Exception $e) {
        throw new Exception("Token inválido: " . $e->getMessage());

    }

}

?>