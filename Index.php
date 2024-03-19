<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Recursos/css/styleCsslogin.css"> <!-- Ajusta la ruta al archivo CSS según tu estructura de proyecto -->



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
            background-size: cover; /* Ajustar tamaño de la imagen */
            background-position: center; /* Centrar la imagen */
        }

        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo semi-transparente para el formulario */
        }

        /* Media queries para ajustar la imagen de fondo en pantallas grandes */
        @media (min-width: 992px) {
            .body_class {
                background-size: contain; /* Cambiar tamaño de la imagen */
                background-position: left; /* Cambiar posición de la imagen */
            }
        }
</style>

<body class="body_class">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-header text-center bg-primary rounded-top InicioSession">
                    Iniciar Sesión
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
                            <input class="form-control" type="text" placeholder="Correo" required name="correo">
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="password" placeholder="Contraseña" required name="clave">
                        </div>
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
                        </div>
                        <?php
                        if (isset($mensaje)) {
                            echo '<div class="form-group">';
                            echo '<div class="alert alert-danger">';
                            echo $mensaje;
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                        <div class="mb-3">
                            ¿No tienes una cuenta? <a href="registarse.php">Regístrate</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>