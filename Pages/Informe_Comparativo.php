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
        $(document).ready(function() {
            $("form").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '../Controladores/Validaciones/BusquedaMuestra.php',
                    type: 'post',
                    data: {
                        year: $('#year').val(),
                        sampleNumber: $('#sampleNumber').val()
                    },
                    success: function(data) {
                        console.log(data);
                        // Parsea los datos devueltos por BusquedaMuestra.php
                        var results = JSON.parse(data);                     
                    }
                });
            });
        });
    </script>
</head>

<body>

    <div>
        <form method="post">
            <div class="container mt-5">
                <h1 class="mb-3"><?php echo $translations['Inf. Comparativo']; ?></h1>
                <form method="post">
                    <div class="mb-3">
                        <label for="sampleNumber" class="form-label"><?php echo $translations['Ingresar Numero de Muestra']; ?></label>
                        <input type="text" class="form-control" id="sampleNumber" name="sampleNumber" placeholder="<?php echo $translations['Ingresar Numero de Muestra']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label"><?php echo $translations['Ingresar Año']; ?></label>
                        <input type="text" class="form-control" id="year" name="year" placeholder="<?php echo $translations['Ingresar Año']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $translations['Comparar']; ?></button>
                </form>
            </div>
        </form>


    </div>
</body>

</html>