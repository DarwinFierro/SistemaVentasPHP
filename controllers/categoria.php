<?php
require_once("../models/Categoria.php");

$categoria = new Categoria();

$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";

$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";

$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

switch ($_GET["op"]) {
    case 'guardareditar':
        if (empty($idcategoria)) {
            $respuesta =$categoria->insertar($nombre,$descripcion);
            echo $respuesta? "Categoria registrada":"Categoria no se pudo registrar";
        }else {
            $respuesta =$categoria->editar($idcategoria,$nombre,$descripcion);
            echo $respuesta? "Categoria Editada":"Categoria no se pudo Editar";
        }
        break;

    case 'desactivar':
        $respuesta =$categoria->desactivar($idcategoria);
        echo $respuesta? "Categoria Desactivada":"Categoria no se pudo Desactivar";
        break;

    case 'activar':
        $respuesta =$categoria->activar($idcategoria);
        echo $respuesta? "Categoria Activada":"Categoria no se pudo Activar";
        break;

    case 'mostrar':
        $respuesta=$categoria->mostrar($idcategoria);
        echo json_encode($respuesta);
        break;

    case 'listar':
        $respuesta=$categoria->listar();
        $data=array();
        while ($resp=$respuesta->fetch_object()) {
            $data[]=array(
                "0"=>$resp->idcategoria,
                "1"=>$resp->nombre,
                "2"=>$resp->descripcion,
                "3"=>$resp->condicion
            );
        }
        $result=array(
            "echo"=>1,
            "totalrecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
        echo json_encode($result);
        break;
}
?>