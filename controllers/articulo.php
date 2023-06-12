<?php
require_once("../models/Articulo.php");

$articulo = new Articulo();

$idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "";

$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";

$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";

$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";

$stock = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]) : "";

$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
    case 'guardareditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        }else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)). '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/".$imagen);
            }
        }

        if (empty($idarticulo)) {
            $respuesta =$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $respuesta? "Articulo registrado":"Articulo no se pudo registrar";
        }else {
            $respuesta =$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $respuesta? "Articulo Editado":"Articulo no se pudo Editar";
        }
        break;

    case 'desactivar':
        $respuesta =$articulo->desactivar($idarticulo);
        echo $respuesta? "Articulo Desactivado":"Articulo no se pudo Desactivar";
        break;

    case 'activar':
        $respuesta =$articulo->activar($idarticulo);
        echo $respuesta? "Articulo Activado":"Articulo no se pudo Activar";
        break;

    case 'mostrar':
        $respuesta=$articulo->mostrar($idarticulo);
        echo json_encode($respuesta);
        break;

    case 'listar':
        $respuesta=$articulo->listar();
        $data=array();
        while ($resp=$respuesta->fetch_object()) {
            $data[]=array(
                "0"=>($resp->condicion)?'<button class="btn btn-warning m-1" onclick="mostrar('.$resp->idarticulo.')"><i class="fas fa-info-circle"></i></button>'.
                '<button class="btn btn-danger m-1" onclick="desactivar('.$resp->idarticulo.')"><i class="fas fa-times"></i></button>':
                '<button class="btn btn-warning m-1" onclick="mostrar('.$resp->idarticulo.')"><i class="fas fa-info-circle"></i></button>'.
                '<button class="btn btn-success m-1" onclick="activar('.$resp->idarticulo.')"><i class="fas fa-check"></i></button>',
                "1"=>$resp->cat_nombre,
                "2"=>$resp->nombre,
                "3"=>$resp->codigo,
                "4"=>$resp->stock,
                "5"=>$resp->descripcion,
                "6"=>"<img src='../files/articulos/".$resp->imagen."' height='50px' width='50px'>",
                "7"=>($resp->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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