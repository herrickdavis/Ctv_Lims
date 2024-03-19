<?php

include '../config.php';
// Establecer el idioma predeterminado en 'en' si no se ha seleccionado ninguno

$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';
$translations = json_decode(file_get_contents(ROOT_URL . "Lenguaje-$language.json"), true);

?>
<nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-custom-color border-bottom box-shadow mb-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="index.php">
                <img src="<?php echo ROOT_URL; ?>Recursos/img/LogoALS_SinFondo.png" alt="Logo" style="max-width: 70px;">
                CTV_LimsInformes
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-end">
            <!-- Language Switcher -->


            <!-- Navigation Items -->
            <ul class="navbar-nav">
                <li class='nav-item'>
                    <a href='<?php echo ROOT_URL; ?>Pages/Principal' class='nav-link text-dark special-home'>
                        <h1 class='custom-text-size'><?php echo $translations['star']; ?></h1>
                    </a>
                </li>



                <!-- Dropdown Menu -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Emision
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>/Pages/Informe_Comparativo">Inf. Comparativo</a></li>
                        <!-- Agrega más elementos aquí si necesitas -->
                    </ul>
                </li>
                <!-- Logout -->
                <li class='nav-item'>
                    <a href='<?php echo ROOT_URL; ?>' class='nav-link text-dark'>Cerrar Sesion</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<style>
    /* Your CSS styles here */
    .language-switcher {
        position: relative;
        display: inline-block;
        padding-right: 20px;
    }

    .language-switcher .dropdown-toggle {
        background: transparent;
        border: none;
        padding: 0;
    }
</style>