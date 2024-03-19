<?php
// Incluye el archivo de conexión
require_once "../Conexion/Conexion.php";

// Comprueba si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene las credenciales del formulario
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Prepara la consulta SQL
    $sql = "SELECT * FROM usuario WHERE Correo = ? AND Clave = ?";

    // Prepara la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincula las variables a la declaración preparada
        $claveHashedInput = hash('sha256', $clave);
        $stmt->bind_param("ss", $correo, $claveHashedInput);

        // Ejecuta la declaración
        if ($stmt->execute()) {
            // Almacena el resultado
            $stmt->store_result();

            // Comprueba si las credenciales son correctas
            if ($stmt->num_rows == 1) {
                // Las credenciales son correctas, inicia la sesión
                session_start();
                $_SESSION['loggedin'] = true;

                // Redirige al usuario a la página principal
                header("location: ../../Pages/Principal.php");
                exit;
            } else {
                // Las credenciales no son correctas, guarda un mensaje de error en la sesión
                session_start();
                $_SESSION['mensaje'] = "Las credenciales que has introducido no son válidas.{$correo}";
                header("location: ../../index.php");
                exit;
            }
        } else {
            echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
        }

        // Cierra la declaración
        $stmt->close();
    }

    // Cierra la conexión
    $conn->close();
}
?>
