<nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-custom-color border-bottom box-shadow mb-3">
     <div class="container-fluid d-flex justify-content-between align-items-center">
         <div class="d-flex align-items-center">
             <a class="navbar-brand" asp-area="" asp-controller="Home" asp-action="Index">
                 <img src="~/imagen/LogoALS_SinFondo.png" alt="Logo" style="max-width: 70px;">
                 CTV_LimsInformes
             </a>
         </div>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                 aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="navbar-collapse collapse justify-content-end">
             <div class="language-switcher">
                 <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                     <img src="~/imagen/en-es.svg" alt="Selected Language"> <!-- La bandera del idioma actual -->
                 </button>
                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                   
                     <li data-value="es">
                         <img src="~/imagen/es.svg" alt="Español"> Español
                     </li>
                     <li data-value="en-US">
                         <img src="~/imagen/en-es.svg" alt="English"> English
                     </li>
                 </ul>
             </div>
             <ul class="navbar-nav">
                 <!-- Resto de tus elementos -->
                 <li class="nav-item">
                     <a class="nav-link text-dark special-home" asp-area="" asp-controller="Home" asp-action="Index">Inicio</a>
                 </li>
                 <li class="nav-item dropdown">
                     <a class="nav-link text-dark dropdown-toggle" href="#" id="informesDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Emision
                     </a>
                     <div class="dropdown-menu" aria-labelledby="informesDropdown">
                         <a class="nav-link text-dark" asp-area="" asp-controller="Comparativo" asp-action="Listar">Inf. Comparativo</a>
                     </div>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link text-dark" asp-area="" asp-controller="Home" asp-action="CerrarSession">Cerrar Sesion</a>
                 </li>
             </ul>                 

             <form id="languageForm" asp-controller="Home" asp-action="EstablecerCultura" asp-route-retornaUrl="@urlActual" method="post" style="display:none;">
                 <input type="hidden" name="nuevaCultura" id="selectedLanguage" />
             </form>
         </div>
     </div>
 </nav>