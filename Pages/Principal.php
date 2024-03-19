<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../Recursos.php';

    ?>
    <title>Document</title>
</head>
<style>
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

    .language-switcher .dropdown-toggle img {
        width: 25px;

    }

    .language-switcher .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .language-switcher .dropdown-menu li {
        padding: 10px 20px;

        text-decoration: none;
        display: block;
        color: #333;
        white-space: nowrap;
    }

    .language-switcher .dropdown-menu li img {
        width: 30px;

        margin-right: 10px;
        vertical-align: middle;

    }

    .language-switcher .dropdown-menu li:hover {
        background-color: #f1f1f1;
    }

    .language-switcher .dropdown-toggle::after {
        display: none;

    }

    .language-switcher .dropdown-toggle[aria-expanded="true"]+.dropdown-menu {
        display: block;
    }

    .navbar-brand img {
        max-width: 70px;
        height: auto;
        margin-right: 0px;
        margin-bottom: 0px;
        padding: 0px;
    }

    .navbar-brand {
        padding: 0px;
    }

    .bg-custom-color {
        background-color: #D8ECF2;
    }

    .special-home {
        background-color: #005DA8;
        color: white !important;
        padding: 5px 10px;

        border-radius: 5px;

    }

    .special-home a {
        color: white !important;
    }

    .custom-text-size {
        font-size: 14px;

        padding-bottom: 0;
        margin-top: 5px;
    }

    .responsive-bg {
        padding-top:0;
        background: url('../Recursos/img/FondoInicio.svg') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        height: 100vh; /* Añade esta línea */
    }
</style>

<body>
    <?php include "../menu.php" ?>
    <div class="responsive-bg">
        <!-- Contenido adicional aquí -->
    </div>

</body>

</html>