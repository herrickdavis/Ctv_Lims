<?php
// Lee el archivo de configuración
$config = json_decode(file_get_contents("../../config.json"), true);

// Selecciona la cadena de conexión
$selectedConnectionString = $config['ConnectionStrings']['cadenaSqlServer'];

// Parsea la cadena de conexión
$connectionParts = parse_url($selectedConnectionString);

// Extrae los detalles de la conexión
$server = $connectionParts['host'];
$database = substr($connectionParts['path'], 1);
$username = $connectionParts['user'];
$password = $connectionParts['pass'];

// Crea la conexión
$conn = new mysqli($server, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ahora puedes usar $conn para hacer consultas a tu base de datos
