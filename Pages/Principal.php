<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../Recursos.php'  ?>
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
        /* Transparente o cualquier otro color de fondo */
        border: none;

        padding: 0;
    }

    .language-switcher .dropdown-toggle img {
        width: 25px;
        /* Tamaño de la bandera */
    }

    .language-switcher .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #ffffff;
        /* Fondo blanco para la lista */
        min-width: 160px;
        /* O el ancho que prefieras */
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .language-switcher .dropdown-menu li {
        padding: 10px 20px;
        /* Ajusta el padding para cambiar el tamaño */
        text-decoration: none;
        display: block;
        color: #333;
        white-space: nowrap;
        /* Asegura que el texto no se pase a la siguiente línea */
    }

    .language-switcher .dropdown-menu li img {
        width: 30px;
        /* Ajusta el ancho de las banderas */
        margin-right: 10px;
        vertical-align: middle;
        /* Alinea verticalmente las imágenes con el texto */
    }

    .language-switcher .dropdown-menu li:hover {
        background-color: #f1f1f1;
    }

    .language-switcher .dropdown-toggle::after {
        display: none;
        /* Si quieres ocultar el icono predeterminado del dropdown */
    }

    /* Mostrar el menú al hacer clic */
    .language-switcher .dropdown-toggle[aria-expanded="true"]+.dropdown-menu {
        display: block;
    }


    /**/
    .navbar-brand img {
        max-width: 70px;
        /* Ajusta el tamaño máximo del logo */
        height: auto;
        /* Mantiene la proporción del logo */
        margin-right: 0px;
        /* Agrega un margen entre la imagen y el texto */
        margin-bottom: 0px;
        padding: 0px;
    }

    .navbar-brand {
        padding: 0px;
    }

    /* Agrega el fondo al menú */
    .bg-custom-color {
        background-color: #D8ECF2;
    }

    /* Estilo para el elemento "Home" */
    .special-home {
        background-color: #005DA8;
        color: white !important;
        padding: 5px 10px;
        /* Agrega espaciado para el fondo */
        border-radius: 5px;
        /* Redondea los bordes del fondo */
    }

    .special-home a {
        color: white !important;
    }
</style>

<body>
    <?php include "../menu.php" ?>
</body>

</html>