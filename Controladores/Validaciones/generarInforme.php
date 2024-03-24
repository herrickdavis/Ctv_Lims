<?php

function generarreporte3($datos)
{
    require('../../vendor/tecnickcom/tcpdf/tcpdf.php');

    class MYPDF extends TCPDF
    {

        // Encabezado

        public function Header()
        {
            // Logo
            $image_file =  'LogoALS.jpg'; // Ruta de la imagen del logo
            $this->Image($image_file, 10, 10, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            // Establecer fuente
            $this->SetFont('helvetica', 'B', 20);

            // Título
            $title = 'ALS LS PERU SAC - División Alimentos';
            $this->Cell(0, 15, $title, 0, false, 'C', 0, '', 0, false, 'M', 'M');

            // Salto de línea
            $this->Ln(20);
        }


        // Pie de página
        public function Footer()
        {
            // Posición a 15 mm del final
            $this->SetY(-15);
            // Establecer fuente Arial itálica 8
            $this->SetFont('helvetica', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    // Crear nuevo documento PDF
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

    // Agregar página
    // Establecer información del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tu nombre');
    $pdf->SetTitle('Informe de Ensayo');
    $pdf->SetHeaderMargin(30); // Por ejemplo, establece un margen superior de 30mm para el encabezado

    // Establecer márgenes
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Establecer fuente
    $pdf->SetFont('helvetica', '', 10);

    // Añadir página
    $pdf->AddPage();
    $html_excel = LecturaExcelyComparativo($datos);






    // Contenido del PDF

    $fecha_actual = date('d/m/Y');
    $html = <<<EOD
    <h1 style="font-size:14px; text-align:center;">Informe de ensayo {$datos['resultado_parametros'][0]['Numero_Informe']} / {$datos['resultado_parametros'][0]['year']}</h1>
    <table cellpadding="7" style="font-size:10px; line-height:1;">
        <tr>
            <td style="border: none; vertical-align: top;">
                <table style="font-size:10px; line-height:1.3;">
                    <tr><td><strong>No. de Ensayo:</strong> {$datos['resultado_parametros'][0]['Num_ensayo']}/ {$datos['resultado_parametros'][0]['year']}</td></tr>
                    <tr><td><strong>Fecha de Emisión:</strong> {$fecha_actual}</td></tr>
                    <tr><td><strong>Fecha Recepción:</strong> {$datos['data'][0]['datarecepcion']->format('d/m/Y')}</td></tr>
                    <tr><td><strong>Fecha Inicio Ensayos:</strong> {$datos['data'][0]['Fecha_inicio_ensayo']->format('d/m/Y')}</td></tr>
                    <tr><td><strong>Código del Cliente:</strong> {$datos['data'][0]['Codigo_Cliente']}</td></tr>
                </table>
            </td>
            <td style="border: 1px solid black; vertical-align: top;">
                <table style="font-size:10px; line-height:1.2;">
                    <tr><td><strong>Sr(s):</strong></td></tr>
                    <tr><td>{$datos['data'][0]['NombreCliente']}</td></tr>
                    <tr><td>{$datos['data'][0]['Direccion']}</td></tr>
                    <tr><td>{$datos['data'][0]['Pais']}</td></tr>
                </table>
            </td>
        </tr>
    </table>
    <p style="font-size:10px; font-weight:bold;">Cumplimiento para mercados</p>
    <p style="font-size:10px; font-weight:bold; text-decoration: underline;">Comparativa</p><br>$html_excel
    EOD;
    // Define las dimensiones de la celda
    $ancho = 0; // Ancho de la celda (0 para que ocupe todo el ancho disponible)
    $alto = 0; // Alto de la celda (0 para que se ajuste automáticamente al contenido)
    $x = ''; // Posición x de la celda (vacío para usar la posición actual)
    $y = ''; // Posición y de la celda (vacío para usar la posición actual)
    // $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->writeHTMLCell($ancho, $alto, $x, $y, $html, $border = 0, $ln = 1, $fill = false, $reseth = true, $align = '', $autopadding = true);


    if ($pdf->GetY() > $pdf->getPageHeight() - 50) {  // Ajusta el valor '50' según sea necesario
        $pdf->AddPage();
    }
    // Cerrar y generar el PDF
    $pdf->lastPage();
    $planillaDownload = __DIR__ . "/data2.pdf";
    $pdf->Output($planillaDownload, 'F');
}

use PhpOffice\PhpSpreadsheet\IOFactory;

function LecturaExcelyComparativo($datos_parametros)
{

    if (isset($datos_parametros['error'])) {
        return array('error' => $datos_parametros['error']);
        exit();
    }
    require '../../vendor/autoload.php';
    $ruta_excel = '../../Recursos/Template/Comparativo.xlsx';
    $documento = IOFactory::load($ruta_excel);
    // Seleccionar la primera hoja del documento
    $hoja = $documento->getSheet(0);
    // Obtener el número de filas y columnas de la hoja
    $ultima_fila = $hoja->getHighestRow();
    $ultima_columna = $hoja->getHighestColumn();
    $datos = [];
    // Recorrer las filas y columnas para extraer los datos
    for ($fila = 1; $fila <= $ultima_fila; $fila++) {
        for ($columna = 'A'; $columna < $ultima_columna; $columna++) {
            // Obtener el valor de la celda
            $valor_celda = $hoja->getCell($columna . $fila)->getValue();
            // Almacenar el valor en el array asociativo
            $datos[$fila][$columna] = $valor_celda;
        }
    }
    //$html = '<table cellpadding="4" style="font-size: 6.5px; border-collapse: collapse;">';  // Elimina el borde de la tabla y ajusta el tamaño de fuente
    $html = '<table cellpadding="4" style="font-size: 6px; border-collapse: collapse; border: .5px solid black;">';
    // Agrega los encabezados de la tabla con estilos
    $html .= '<thead><tr style="background-color: #307FDC; color: #FFFFFF;"><th colspan="2">Parametro/Resultado/Pais</th>';  // Agrega un color de fondo y color de letra a los encabezados
    foreach ($datos[1] as $pais) {
        if ($pais != "Parametro") {
            $html .= "<th style='background-color: #43A3FF; color: #FFFFFF;'>$pais</th>";  // Estiliza el fondo y color de letra de las columnas de país
        }
    }
    $html .= '</tr></thead><tbody>';

    // Agrega los datos de los parámetros
    foreach ($datos_parametros["resultado_parametros"] as $parametro) {
        $nombre_parametro = $parametro["Parametro"];
        $resultado = floatval($parametro["resultado"]);

        $html .= "<tr><td style='width: 80px;'>$nombre_parametro</td><td>$resultado</td>";  // Agrandar un poco la primera columna

        $parametro_encontrado = false;
        foreach ($datos as $fila) {
            if ($fila["A"] == $nombre_parametro) {
                $parametro_encontrado = true;
                foreach ($fila as $pais => $limite) {
                    if ($pais != "A") {
                        if ($resultado > $limite) {
                            $html .= "<td bgcolor=\"#FFD2D2\" style='color: #FFFFFF;'>$limite</td>";  // Estiliza las celdas de límite superado
                        } else {
                            $html .= "<td bgcolor=\"#D2E8FF\" style='color: #FFFFFF;'>$limite</td>";  // Estiliza las celdas de límite no superado
                        }
                    }
                }
            }
        }
        if (!$parametro_encontrado) {
            // Si el parámetro no se encontró en los datos del Excel, muestra "S/INF" para cada país
            for ($i = 0; $i <= count($datos[1]) - 2; $i++) {
                $html .= "<td>S/INF</td>";
            }
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';  // Cierra la tabla HTML

    // Agrega un título para la segunda tabla
    $html .= ' <p style="font-size:10px; font-weight:bold; text-decoration: underline;">Nivel de Porcentaje Alcanzado</p><br>';


    // Inicia la segunda tabla HTML con estilos CSS
    $html .= '<table cellpadding="4" style="font-size: 6px; border-collapse: collapse; border: .5px solid black;">';
    // Agrega los encabezados de la tabla con estilos
    $html .= '<thead><tr style="background-color: #307FDC; color: #FFFFFF;"><th colspan="2">Parametro/Resultado/Pais</th>';  // Agrega un color de fondo y color de letra a los encabezados
    foreach ($datos[1] as $pais) {
        if ($pais != "Parametro") {
            $html .= "<th style='background-color: #43A3FF; color: #FFFFFF;'>$pais</th>";  // Estiliza el fondo y color de letra de las columnas de país
        }
    }
    $html .= '</tr></thead><tbody>';

    // Agrega los datos de los parámetros
    foreach ($datos_parametros["resultado_parametros"] as $parametro) {
        $nombre_parametro = $parametro["Parametro"];
        $resultado = floatval($parametro["resultado"]);

        $html .= "<tr><td style='width: 80px;'>$nombre_parametro</td><td>$resultado</td>";  // Agrandar un poco la primera columna

        $parametro_encontrado = false;
        foreach ($datos as $fila) {
            if ($fila["A"] == $nombre_parametro) {
                $parametro_encontrado = true;
                foreach ($fila as $pais => $limite) {
                    if ($pais != "A") {
                        if ($limite !== null) {
                            $porcentaje = $resultado / $limite * 100;  // Calcula el porcentaje
                            $porcentaje = floatval($porcentaje);  // Asegúrate de que $porcentaje es un float
                            $porcentaje_redondeado = round($porcentaje, 3);  // Redondea el porcentaje a tres decimales
                            $porcentaje_formateado = rtrim(rtrim($porcentaje_redondeado, '0'), '.');  // Elimina los ceros no significativos y el punto decimal si el número es un entero
                            $porcentaje_formateado = strval($porcentaje_formateado);  // Asegúrate de que $porcentaje_formateado es un string
                            if ($resultado > $limite) {
                                $html .= "<td bgcolor=\"#FFD2D2\" style='color: #FFFFFF;'>$porcentaje_formateado%</td>";
                            } else {
                                $html .= "<td bgcolor=\"#D2E8FF\" style='color: #FFFFFF;'>$porcentaje_formateado%</td>";
                            }
                        } else {
                            $html .= "<td>S/INF</td>";
                        }
                    }
                }
            }
        }
        if (!$parametro_encontrado) {
            // Si el parámetro no se encontró en los datos del Excel, muestra "S/INF" para cada país
            for ($i = 0; $i <= count($datos[1]) - 2; $i++) {
                $html .= "<td>S/INF</td>";
            }
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table><br>';  // Cierra la tabla HTML

    // Agrega la leyenda de colores
    $html .= '<br><br>
    <table style="width: 100%; font-size: 10px;">
        <tr>
            <td style="width: 20px; background-color: #FFD2D2;"></td>
            <td>Rango de concentración supera MRL</td>
        </tr>
        <tr>
            <td style="width: 20px; background-color: #FFE674;"></td>
            <td>Rango de concentración incluye MRL</td>
        </tr>
        <tr>
            <td style="width: 20px; background-color: #D2E8FF;"></td>
            <td>Rango de concentración inferior a MRL</td>
        </tr>
    </table>';
    // Agrega la nota al final
    $html .= '<p style="font-size: 6px;"><strong>"S/INF":</strong> Sin información de mercado<br><br>';

    $html .= '<strong>Nota:</strong> Este anexo es información de referencia cualquier decisión tomada en base a estos resultados no son responsabilidad del laboratorio que envió este reporte. ALS mantiene los requisitos de mercados actualizado, por lo que los criterios de evaluación representan la fecha de emisión de los reportes vinculados.</p>';
    // Retorna el HTML
    return $html;
}

function leerExcelTcpdf()
{
    require '../../vendor/autoload.php';
    $ruta_excel = '../../Recursos/Template/Comparativo.xlsx';
    $documento = IOFactory::load($ruta_excel);
    // Seleccionar la primera hoja del documento
    $hoja = $documento->getSheet(0);
    // Obtener el número de filas y columnas de la hoja
    $ultima_fila = $hoja->getHighestRow();
    $ultima_columna = $hoja->getHighestColumn();
    $datos = [];
    // Recorrer las filas y columnas para extraer los datos
    for ($fila = 1; $fila <= $ultima_fila; $fila++) {
        for ($columna = 'A'; $columna < $ultima_columna; $columna++) {
            // Obtener el valor de la celda
            $valor_celda = $hoja->getCell($columna . $fila)->getValue();
            // Almacenar el valor en el array asociativo
            $datos[$fila][$columna] = $valor_celda;
        }
    }
    return $datos;
}
/*
    //$pdf->writeHTML($html_excel, true, false, true, false, '');


    $fecha_actual = date('d/m/Y');
    $pdf->SetFont('helvetica', '', 10);



    // Definir el tipo de letra y el tamaño para su uso posterior
    $fontType = 'helvetica';
    $fontSize = 10;

    // Título
    $pdf->SetFont($fontType, 'B', $fontSize + 4);
    $pdf->Cell(0, 10, 'Informe de ensayo ' . $datos['resultado_parametros'][0]['Numero_Informe'] . ' / ' . $datos['resultado_parametros'][0]['year'], 0, 1, 'C');

    $pdf->Ln(3);
    $y = $pdf->GetY();
    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(30, 5, 'No. de Ensayo: ', 0, 0);
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->Cell(25, 5, $datos['resultado_parametros'][0]['Num_ensayo'] . '/' . $datos['resultado_parametros'][0]['year'], 0, 1, 'L');
    $pdf->Ln(0);
    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(35, 5, 'Fecha de Emisión: ', 0, 0);
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->Cell(25, 5, $fecha_actual, 0, 1, 'L');
    // Continuación de la tabla a la izquierda
    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(35, 5, 'Fecha Recepción: ', 0, 0);
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->Cell(25, 5, $datos['data'][0]['datarecepcion']->format('d/m/Y'), 0, 1, 'L');

    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(45, 5, 'Fecha Inicio Ensayos: ', 0, 0);
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->Cell(25, 5, $datos['data'][0]['Fecha_inicio_ensayo']->format('d/m/Y'), 0, 1, 'L');

    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(40, 5, 'Código del Cliente: ', 0, 0);
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->Cell(25, 5, $datos['data'][0]['Codigo_Cliente'], 0, 1, 'L');
    $yFinal = $pdf->GetY();
    // Mover el cursor a la derecha para la tabla del lado derecho

    $pdf->SetFillColor(255, 255, 255);  // Establece el color de relleno en blanco


    // Guardar la posición actual del cursor después de 'No. de Ensayo:'   
    // Mover el cursor a la derecha para la tabla del lado derecho
    $pdf->SetXY(110, $y);
    // Tabla del lado derecho
    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(15, 10, 'Sr(s):', 0, 0, 'L');
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->MultiCell(65, 10, $datos['data'][0]['NombreCliente'], 0, 'L');

    $pdf->SetXY(110, $y + 10);  // Mover el cursor hacia abajo para la siguiente fila
    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(20, 10, 'Dirección:', 0, 0, 'L');
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->MultiCell(60, 10, $datos['data'][0]['Direccion'], 0, 'L');

    $pdf->SetXY(110, $y + 20);  // Mover el cursor hacia abajo para la siguiente fila
    $pdf->SetFont($fontType, 'B', $fontSize);
    $pdf->Cell(15, 10, 'País:', 0, 0, 'L');
    $pdf->SetFont($fontType, '', $fontSize);
    $pdf->MultiCell(65, 10, $datos['data'][0]['Pais'], 0, 'L');

    // Dibujar el borde de la tabla
    $pdf->SetXY(110, $y);
    $pdf->Cell(80, 30, '', 1);  // Ajusta el '30' según sea necesario


    $pdf->SetY($yFinal + 20);
    //colocar la comparativoa, extraer datos y mostrar#######################################
    $pdf->Cell(0, 10, 'Contenido anterior', 0, 1, 'C');
    $y = $pdf->GetY();

    $datos_excel = leerExcelTcpdf();

    // Establecer el tamaño de la fuente
    $pdf->SetFont($fontType, '', 8);  // Cambia '10' al tamaño de fuente que prefieras

    // Ajustar el ancho de las celdas
    $ancho_celda = $pdf->getPageWidth() / count($datos_excel[1]);  // Calcula el ancho de la celda en función del número de columnas y el ancho de la página

    // Aquí comienza la tabla
    $pdf->Cell($ancho_celda, 10, 'Parametro', 1, 0, 'C', true);  // Usa el ancho de la celda calculado
    $pdf->Cell($ancho_celda, 10, 'Resultado', 1, 0, 'C', true);  // Usa el ancho de la celda calculado

    // Agrega los nombres de los países
    foreach ($datos_excel[1] as $pais) {
        if ($pais != "Parametro") {
            $pdf->Cell($ancho_celda, 10, $pais, 1, 0, 'C', true);  // Usa el ancho de la celda calculado
        }
    }
    $pdf->Ln();  // Nueva línea

    // Agrega los datos de los parámetros
    foreach ($datos["resultado_parametros"] as $parametro) {
        $nombre_parametro = $parametro["Parametro"];
        $resultado = floatval($parametro["resultado"]);

        $pdf->Cell($ancho_celda, 10, $nombre_parametro, 1);  // Usa el ancho de la celda calculado
        $pdf->Cell($ancho_celda, 10, $resultado, 1);  // Usa el ancho de la celda calculado

        $parametro_encontrado = false;
        foreach ($datos_excel as $fila) {
            if ($fila["A"] == $nombre_parametro) {
                $parametro_encontrado = true;
                foreach ($fila as $pais => $limite) {
                    if ($pais != "A") {
                        if ($resultado > $limite) {
                            $pdf->SetFillColor(255, 210, 210);  // Estiliza las celdas de límite superado
                        } else {
                            $pdf->SetFillColor(210, 232, 255);  // Estiliza las celdas de límite no superado
                        }
                        $pdf->Cell($ancho_celda, 10, $limite, 1, 0, 'C', true);  // Usa el ancho de la celda calculado
                    }
                }
            }
        }
        if (!$parametro_encontrado) {
            // Si el parámetro no se encontró en los datos del Excel, muestra "S/INF" para cada país
            for ($i = 0; $i <= count($datos_excel[1]) - 2; $i++) {
                $pdf->Cell($ancho_celda, 10, 'S/INF', 1);  // Usa el ancho de la celda calculado
            }
        }
        $pdf->Ln();  // Nueva línea
    } #####################################################################################
    // Comprobar si el cursor está cerca del final de la página
    if ($pdf->GetY() > $pdf->getPageHeight() - 50) {  // Ajusta el valor '50' según sea necesario
        $pdf->AddPage();
    }


    $pdf->lastPage();
    $planillaDownload = __DIR__ . "/data2.pdf";
    $pdf->Output($planillaDownload, 'F');
*/