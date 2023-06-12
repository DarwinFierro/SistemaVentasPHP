<?php
require_once("../models/Persona.php");

$persona = new Persona();

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";

$tipo_persona = isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]) : "";

$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";

$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";

$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";

$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";

$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";

$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";


switch ($_GET["op"]) {
    case 'guardareditar':

        if (empty($idpersona)) {
            $respuesta = $persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $respuesta ? "persona registrado" : "persona no se pudo registrar";
        } else {
            $respuesta = $persona->editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $respuesta ? "persona Editado" : "persona no se pudo Editar";
        }
        break;

    case 'mostrar':
        $respuesta = $persona->mostrar($idpersona);
        echo json_encode($respuesta);
        break;

    case 'eliminar':
        $respuesta = $persona->eliminar($idpersona);
        echo $respuesta ? "Persona Desactivado" : "Persona no se pudo Desactivar";
        break;

    case 'listarCliente':
        $respuesta = $persona->listarCliente();
        $data = array();
        while ($resp = $respuesta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning m-1" onclick="mostrar(' . $resp->idpersona . ')"><i class="fas fa-info-circle"></i></button>' .
                '<button class="btn btn-danger m-1" onclick="eliminar(' . $resp->idpersona . ')"><i class="fas fa-trash"></i></button>',
                "1" => $resp->nombre,
                "2" => $resp->tipo_documento,
                "3" => $resp->num_documento,
                "4" => $resp->direccion,
                "5" => $resp->telefono,
                "6" => $resp->email
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

    case 'listarProvedor':
        $respuesta = $persona->listarProvedor();
        $data = array();
        while ($resp = $respuesta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning m-1" onclick="mostrar(' . $resp->idpersona . ')"><i class="fas fa-info-circle"></i></button>' .
                '<button class="btn btn-danger m-1" onclick="desactivar(' . $resp->idpersona . ')"><i class="fas fa-times"></i></button>',
                "1" => $resp->nombre,
                "2" => $resp->tipo_documento,
                "3" => $resp->num_documento,
                "4" => $resp->direccion,
                "5" => $resp->telefono,
                "6" => $resp->email
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