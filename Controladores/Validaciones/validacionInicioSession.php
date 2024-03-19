<?php
// Incluye el archivo de conexión
require_once "../Conexion/Conexion.php";

// Comprueba si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    // Obtiene las credenciales del formulario
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    
    // Prepara la consulta SQL
    $sql = "SELECT * FROM usuario WHERE Correo = ?";
    echo "correo capturados {$correo} y clave {$clave}";
    // Prepara la declaración
    if ($stmt = $conn->prepare($sql)) {
        echo "Conexion establecida";
        // Vincula las variables a la declaración preparada
        $stmt->bind_param("s", $correo);

        // Ejecuta la declaración
        if ($stmt->execute()) {
            // Almacena el resultado
            $stmt->store_result();
            echo "Ejecuto";
            // Comprueba si el correo existe en la base de datos
            if ($stmt->num_rows == 1) {
                // Vincula las variables de resultado
                $stmt->bind_result($id, $nombreUsuario, $correo, $claveHashed);
                echo "Trajo data";
                // Obtiene la fila de resultado
                if ($stmt->fetch()) {
                    // Comprueba si la contraseña es correcta
                    if (password_verify($clave, $claveHashed)) {
                        // La contraseña es correcta, inicia la sesión
                        echo "Trajo data";
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $id;
                        $_SESSION['correo'] = $correo;
                        
                        // Redirige al usuario a la página principal
                        header("location: Pages/Principal.php");
                    } else {
                        // La contraseña no es correcta, muestra un mensaje de error
                        $mensaje = "La contraseña que has introducido no es válida.";
                    }
                }
            } else {
                // El correo no existe en la base de datos, muestra un mensaje de error
                $mensaje = "No se encontró ninguna cuenta con ese correo.";
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
