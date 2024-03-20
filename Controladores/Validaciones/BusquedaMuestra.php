<?php
include '../Conexion/Conexion.php';
include 'Mostrarparametros.php';


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
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_execute($stmt) === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $data[] = $row;
}
$resultado_parametros_ES = ExtraerParametros($_POST['year'], $_POST['sampleNumber']);

$nuevoJson_params_EN=consultarEquivalencias(json_encode($resultado_parametros_ES));

$response = array(
    'resultado_parametros' => $resultado_parametros_ES,
    'data' => $data
);
echo json_encode($data);
