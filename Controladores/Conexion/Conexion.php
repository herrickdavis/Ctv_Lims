<?php
// Lee el archivo de configuración
$config = json_decode(file_get_contents("../../config.json"), true);

// Selecciona la cadena de conexión
$selectedConnectionString = $config['ConnectionStrings']['cadenaSqlServer'];

// Extrae los detalles de la conexión
$details = explode(";", $selectedConnectionString);
$server = explode("=", $details[0])[1];
$database = explode("=", $details[1])[1];
$username = explode("=", $details[2])[1];
$password = explode("=", $details[3])[1];

// Crea la conexión
$conn = new mysqli($server, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ahora puedes usar $conn para hacer consultas a tu base de datos
?>
