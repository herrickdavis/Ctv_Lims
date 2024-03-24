<?php
if (isset($_POST['resultados'])) {
    $data = json_decode($_POST['resultados'], true);
    $resultados = $data['resultado_parametros']; // Accede a la clave 'resultado_parametros'
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr><th>Numero_Muestra</th><th>year</th><th>N° Analisis</th><th>N° Informe</th><th>ID Parametro</th><th>Parametro</th><th>Resultado</th><th>Num_ensayo</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($resultados as $resultado) {
        echo "<tr>";
        echo "<td>" . $resultado['Numero_Muestra'] . "</td>";
        echo "<td>" . $resultado['year'] . "</td>";
        echo "<td>" . $resultado['NUMERO_ANALISIS'] . "</td>";
        echo "<td>" . $resultado['Numero_Informe'] . "</td>";
        echo "<td>" . $resultado['Idparametro'] . "</td>";
        echo "<td>" . $resultado['Parametro'] . "</td>";
        echo "<td>" . $resultado['resultado'] . "</td>";
        echo "<td>" . $resultado['Num_ensayo'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}
