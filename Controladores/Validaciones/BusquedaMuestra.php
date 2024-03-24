<?php
session_start();

include '../Conexion/Conexion.php';
include 'Mostrarparametros.php';
include 'generarInforme.php';
try {
    //1.Extrae datos de Encabezado######################################################
    $sql = "SELECT m.Cliente as Codigo_Cliente, m.DataRecepcao as datarecepcion, a.DataInicio as Fecha_inicio_ensayo, 
        m.NomeCliente as NombreCliente, m.Morada as Direccion, m.Localidade as Pais 
        FROM TDE_Amostras M 
        LEFT JOIN Clientes CLI ON CLI.Cliente = m.Cliente 
        LEFT JOIN TDE_ClientesUnidades CLIU ON CLIU.Cliente = M.Cliente AND CLIU.Unidade = M.unidadecliente 
        LEFT JOIN TDE_ClassesProdutos CP ON CP.ClasseProdutos = M.ClasseProdutos 
        LEFT JOIN TiposProdutos TP ON TP.TipoProduto = M.TipoProduto 
        LEFT JOIN Laboratorios lab ON lab.idlaboratorio = M.labid 
        LEFT JOIN TiposRecolhas TR ON TR.IdTipoRecolha = M.TipoRecolha 
        LEFT JOIN TDE_CabecDoc A ON A.Ano = M.Ano AND A.NumAmostra = M.NumAmostra AND A.TipoDoc LIKE 'A%' 
        WHERE YEAR(A.Data) >= ? AND A.NumAmostra = ?
        GROUP BY m.Cliente, m.DataRecepcao, a.DataInicio, m.NomeCliente, m.Morada, m.Localidade";

    $params = array(&$_POST['sampleNumber'], &$_POST['year']);
    $stmt = sqlsrv_prepare($connSqlServer, $sql, $params);

    if ($stmt === false) {
        // die(print_r(sqlsrv_errors(), true));
        echo json_encode(array('error-Busqueda' => print_r(sqlsrv_errors(), true)));
        die();
    }

    if (sqlsrv_execute($stmt) === false) {
        //die(print_r(sqlsrv_errors(), true));
        echo json_encode(array('error-Busqueda' => print_r(sqlsrv_errors(), true)));
        die();
    }

    $data_Cliente = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        $data_Cliente[] = $row;
    }
    //Termina obtener datos de cliente encabezado######################################################
    //2. Obtiene datos de parametros y resultados######################################################
    $resultado_parametros_ES = ExtraerParametros($_POST['year'], $_POST['sampleNumber']); //
    // Verificar si $resultado_parametros_ES contiene un error
    if (isset($resultado_parametros_ES['error-ExtraerParametros'])) {
        throw new Exception(json_encode($resultado_parametros_ES));
    }
    //Termina Obtiene datos de parametros y resultados#################################################
    //3. extrae Equivalencias de parametros en ingles apra coparativa##################################
    $nuevoJson_params_EN = consultarEquivalencias(json_encode($resultado_parametros_ES));
    //3. extrae Equivalencias de parametros en ingles apra coparativa##################################
    $response = array(
        'resultado_parametros' => $resultado_parametros_ES,
        'data' => $data_Cliente
    );

    // Unifica los dos JSON en uno solo
    $datos_reporte = array(
        'resultado_parametros' => $nuevoJson_params_EN,
        'data' => $data_Cliente,
        'resultados_parametrosES' => $resultado_parametros_ES
    );
    echo json_encode($datos_reporte);

    // Llama a la función GenerarReporte pasándole el JSON unificado
    generarreporte3($datos_reporte);
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
