<?php
//Lee el archivo de configuración
/*
$config = json_decode(file_get_contents("../../config.json"), true);

// Selecciona las cadenas de conexión
$connectionStringMySQL = $config['ConnectionStrings']['cadenaSqlServer'];
$connectionStringSqlServer = $config['ConnectionStrings']['cadenaSqlServer2'];

// Extrae los detalles de la conexión
$detailsMySQL = explode(";", $connectionStringMySQL);
$serverMySQL = explode("=", $detailsMySQL[0])[1];
$databaseMySQL = explode("=", $detailsMySQL[1])[1];
$usernameMySQL = explode("=", $detailsMySQL[2])[1];
$passwordMySQL = explode("=", $detailsMySQL[3])[1];

$detailsSqlServer = explode(";", $connectionStringSqlServer);
$serverSqlServer = explode("=", $detailsSqlServer[0])[1];
$databaseSqlServer = explode("=", $detailsSqlServer[1])[1];
$usernameSqlServer = explode("=", $detailsSqlServer[2])[1];
$passwordSqlServer = explode("=", $detailsSqlServer[3])[1];

// Crea las conexiones
$conn = new mysqli($serverMySQL, $usernameMySQL, $passwordMySQL, $databaseMySQL);
$connSqlServer = sqlsrv_connect($serverSqlServer, array("Database"=>$databaseSqlServer, "UID"=>$usernameSqlServer, "PWD"=>$passwordSqlServer));

// Verifica las conexiones
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($connSqlServer === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ahora puedes usar $connMySQL y $connSqlServer para hacer consultas a tus bases de datos
*/



//Lee el archivo de configuración
$config = json_decode(file_get_contents("../../config.json"), true);

// Selecciona las cadenas de conexión
$connectionStringMySQL = $config['ConnectionStrings']['cadenaSqlServer'];
$connectionStringSqlServer = $config['ConnectionStrings']['cadenaSqlServer2'];

// Extrae los detalles de la conexión
$detailsMySQL = explode(";", $connectionStringMySQL);
$serverMySQL = explode("=", $detailsMySQL[0])[1];
$databaseMySQL = explode("=", $detailsMySQL[1])[1];
$usernameMySQL = explode("=", $detailsMySQL[2])[1];
$passwordMySQL = explode("=", $detailsMySQL[3])[1];



// Crea las conexiones
$conn = new mysqli($serverMySQL, $usernameMySQL, $passwordMySQL, $databaseMySQL);

// Verifica las conexiones
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Datos de conexión a SQL Server
$serverSqlServer = "SALMLWS004";
$databaseSqlServer = "LabAlsPE";
$usernameSqlServer = "sa";
$passwordSqlServer = "1qaz2WSX";

// Crea la conexión a SQL Server
$connSqlServer = sqlsrv_connect($serverSqlServer, array(
    "Database" => $databaseSqlServer,
    "UID" => $usernameSqlServer,
    "PWD" => $passwordSqlServer,
    "TrustServerCertificate" => true
));

// Verifica la conexión
if ($connSqlServer === false) {
    // Captura los errores
    $errors = sqlsrv_errors();

    // Crea un array para almacenar los mensajes de error
    $errorMessages = array();

    // Recorre cada error y agrega el mensaje de error al array
    foreach ($errors as $error) {
        $errorMessages[] = $error['message'];
    }

    // Devuelve los mensajes de error como un JSON
    //echo json_encode(array('errors' => $errorMessages));
    exit;
} else {
    //echo json_encode(array('success' => 'Conexión establecida con éxito'));
}

// Si la conexión se estableció correctamente, devuelve un mensaje de éxito

// Cerrar la conexión SQL Server no es necesario aquí
// sqlsrv_close($connSqlServer);
?>

