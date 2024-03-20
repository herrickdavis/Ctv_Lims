<?php
function ExtraerParametros($year, $numeroMuestra)
{
    include '../Conexion/Conexion.php';

    try {
        $sql = "SELECT DISTINCT
        am.NumAmostra AS Numero_Muestra,
        am.Ano AS year,
        an.NumDoc AS NUMERO_ANALISIS,
        an.UltNumRel AS Numero_Informe,
        --CONVERT(anl.Descricao USING ASCII) AS ensayo
        anrls.IdSubEnsaio as Idparametro,
        anrls.Descricao AS Parametro,
        anrls.rValor1 AS resultado
       
    FROM
        TDE_Amostras am
        INNER JOIN TDE_CabecDoc an ON am.NumAmostra = an.NumAmostra
        AND am.Ano = an.Ano
        AND an.TipoDoc = 'AAQ'
        INNER JOIN TDE_LinhasDoc anl ON anl.Ano = an.Ano
        AND anl.TipoDoc = an.TipoDoc
        AND anl.NumDoc = an.NumDoc
        INNER JOIN AnalisesLinhasResultadosSubEnsaios anrls ON anrls.Ano = anl.Ano
        AND anrls.TipoDoc = anl.TipoDoc
        AND anrls.NumDoc = anl.NumDoc
        AND anrls.OriLin = anl.IdLin
        and not replace (replace (ANRLS.rtexto, ' ', ''), '.', '') like '%LQ%'
        AND anrls.Repeticao = 0
        LEFT JOIN Criterios cr_comcp ON cr_comcp.Ensaio = anl.Artigo
        AND cr_comcp.IdUnidadeMedida = anrls.IdUnidadeMedidaFinal
        AND cr_comcp.IdMetodo = anrls.IdMetodo
        AND cr_comcp.IdSubEnsaio = anrls.IdSubEnsaio
        AND cr_comcp.classeprodutos = am.classeprodutos
        LEFT JOIN Criterios cr_semcp ON cr_semcp.Ensaio = anl.Artigo
        AND cr_semcp.IdUnidadeMedida = anrls.IdUnidadeMedidaFinal
        AND cr_semcp.IdMetodo = anrls.IdMetodo
        AND cr_semcp.IdSubEnsaio = anrls.IdSubEnsaio
        AND SUBSTRING(cr_semcp.classeprodutos, 1, 2) = SUBSTRING(am.classeprodutos, 1, 2)
        WHERE     YEAR(an.Data) >= ? AND an.NumAmostra = ?";

        $params = array(&$_POST['year'], &$_POST['sampleNumber']);
        $stmt = sqlsrv_prepare($connSqlServer, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Error preparing the statement: ' . print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_execute($stmt) === false) {
            throw new Exception('Error executing the statement: ' . print_r(sqlsrv_errors(), true));
        }

        $data = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }

        if (empty($data)) {
            //echo json_encode(array('error' => 'No data found'));
        } else {
            //echo json_encode($data);
        }
    } catch (Exception $e) {
        //echo json_encode(array('error' => $e->getMessage()));
    }
    return $data;
}

function consultarEquivalencias($json) {
    $data = json_decode($json, true);
    $newData = array();

    // Incluye el archivo de conexión
    //require_once "../Conexion/Conexion.php";
    include '../Conexion/Conexion.php';

    foreach ($data as $item) {
        $idParametro = $item['Idparametro'];

        // Prepara la consulta SQL
        $sql = "SELECT NombreUS FROM equivalencias WHERE idparametro = ?";

        // Prepara la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Vincula las variables a la declaración preparada
            $stmt->bind_param("i", $idParametro);

            // Ejecuta la declaración
            if ($stmt->execute()) {
                // Almacena el resultado
                $result = $stmt->get_result();

                // Obtiene los datos
                while ($row = $result->fetch_assoc()) {
                    $item['Parametro'] = $row['NombreUS'];
                }
            } else {
                echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }

            // Cierra la declaración
            $stmt->close();
        }

        array_push($newData, $item);
    }

    // Cierra la conexión
    $conn->close();

    return json_encode($newData);
}

