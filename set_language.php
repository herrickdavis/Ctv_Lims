<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos JSON de la solicitud POST
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Obtener el idioma seleccionado desde los datos JSON
    $language = $data['language'];

    // Guardar el idioma seleccionado en la sesión para su uso posterior
    session_start();
    $_SESSION['language'] = $language;

    // Enviar una respuesta JSON indicando éxito
    echo json_encode(array('success' => true));
} else {
    // Si no se recibió una solicitud POST, enviar una respuesta JSON de error
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
