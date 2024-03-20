<!DOCTYPE html>
<html lang="en">
<?php
session_start();

$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';
$translations = json_decode(file_get_contents("Lenguaje-$language.json"), true);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<style type="text/css">
    .InicioSession {
        color: #fff;
    }

    .body_class {
        background-image: url('Recursos/img/FondoLogin.svg');
        background-repeat: no-repeat;
        min-height: 100vh;
        overflow: hidden;
        background-size: cover;
        /* Ajustar tamaño de la imagen */
        background-position: center;
        /* Centrar la imagen */
    }

    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9);
     
    }

   
    @media (min-width: 992px) {
        .body_class {
            background-size: contain;
            /* Cambiar tamaño de la imagen */
            background-position: left;
            /* Cambiar posición de la imagen */
        }
    }
</style>

<body class="body_class">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-header text-center bg-primary rounded-top InicioSession">
                    <?php echo $translations['login']; ?>
                </div>

                <div class="card-header text-center rounded-top InicioSession" style="background-color: white;">
                    <div class="d-flex align-items-center text-center">
                        <img src="Recursos/img/LogoALS.png" alt="Logo" class="logo w-25 h-25">
                        <h5 class="mb-0 ml-3" style="background-color: white; color: black; padding: 5px;">CTVLims</h5>
                    </div>
                </div>
               
                <div class="card-body">
                    <form action="Controladores/Validaciones/validacionInicioSession.php" method="post">
                        <div class="mb-3">
                            <input class="form-control" type="text" placeholder="<?php echo $translations['email']; ?>" required name="correo">
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="password" placeholder="<?php echo $translations['password']; ?>" required name="clave">
                        </div>
                        <div class="mb-3">
                            <label for="language-select"><?php echo $translations['select_language']; ?></label>
                            <select class="form-select" id="language-select">
                                <option value="es" <?php echo ($language === 'es') ? 'selected' : ''; ?>>Español</option>
                                <option value="en" <?php echo ($language === 'en') ? 'selected' : ''; ?>>English</option>
                            </select>

                        </div>
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary" type="submit"><?php echo $translations['submit']; ?></button>
                        </div>

                        <?php
                        if (isset($_SESSION['mensaje'])) {
                            echo '<div class="form-group">';
                            echo '<div class="alert alert-danger">';
                            echo $_SESSION['mensaje'];
                            echo '</div>';
                            echo '</div>';
                            // Borra el mensaje de la sesión
                            unset($_SESSION['mensaje']);
                        }
                        ?>
                        <div class="mb-3">
                            <?php echo $translations['no_account']; ?> <a href="registarse.php"><?php echo $translations['register']; ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('language-select').addEventListener('change', function() {
            var selectedLanguage = this.value;

            // Enviar la selección de idioma al servidor
            fetch('set_language.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    language: selectedLanguage
                })
            }).then(function(response) {
                if (response.ok) {
                    // Éxito al cambiar el idioma
                    // Forzar una recarga completa de la página sin caché
                    window.location.reload(true);
                } else {
                    console.error('Error al cambiar el idioma:', response.statusText);
                }
            }).catch(function(error) {
                console.error('Error al cambiar el idioma:', error);
            });
        });
    </script>



</body>


</html>