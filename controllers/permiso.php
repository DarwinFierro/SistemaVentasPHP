<?php
require_once("../models/Permiso.php");

$permiso = new Permiso();


switch ($_GET["op"]) {
    case 'listar':
        $respuesta = $permiso->listar();
        $data = array();
        while ($resp = $respuesta->fetch_object()) {
            $data[] = array(
                "0" => $resp->nombre
            );
        }
        $result = array(
            "echo" => 1,
            "totalrecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($result);
        break;
}
?>