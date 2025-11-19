<?php

function carga_datos()
{
    $requestData = array();

    if (!empty($_POST)) {
        $requestData = $_POST;
    } elseif (!empty($_GET)) {
        $requestData = $_GET;
    }
    if (!empty($_FILES)) {
        foreach ($_FILES as $indice => $archivo) {
            $requestData[$indice] = $archivo;
        }
    }
    if (count($requestData)) {
        foreach ($requestData as $indice => $valor) {
            // Evitamos alterar arrays (como los de $_FILES)
            if (!is_array($valor) && $valor === "") {
                $requestData[$indice] = 'null';
            }
        }
    }
    return $requestData;
}
?>