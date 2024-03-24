<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Document</title>
    <?php include '../Recursos.php';
    include "../menu.php";

    $language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';
    $translations = json_decode(file_get_contents(ROOT_URL . "Lenguaje-$language.json"), true);
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

    </script>
    <script src="../js/ValidarData.js"></script>



</head>

<body>

    <div>
        <form method="post">
            <div class="container mt-5">
                <h1 class="mb-3"><?php echo $translations['Inf. Comparativo']; ?></h1>
                <form method="post">
                    <div class="mb-3">
                        <label for="sampleNumber" class="form-label"><?php echo $translations['Ingresar Numero de Muestra']; ?></label>
                        <input type="text" class="form-control" id="sampleNumber" name="sampleNumber" placeholder="<?php echo $translations['Ingresar Numero de Muestra']; ?>" require>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label"><?php echo $translations['Ingresar Año']; ?></label>
                        <input type="text" class="form-control" id="year" name="year" placeholder="<?php echo $translations['Ingresar Año']; ?>" require>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $translations['Comparar']; ?></button>
                </form>
            </div>
            <div id="divTabla" class="container-md mx-auto">
            </div>

        </form>


    </div>
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Alerta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="alertModalBody">
                    <!-- El mensaje de la alerta se insertará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>