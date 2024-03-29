<?php

session_start();
require_once("../models/Usuario.php");

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
    case 'guardareditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        }else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)). '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/".$imagen);
            }
        }

        $clavehash=hash("SHA256",$clave);

        if (empty($idusuario)) {
            $respuesta = $usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $respuesta ? "usuario registrada" : "usuario no se pudo registrar";
        } else {
            $respuesta = $usuario->editar($idusuario, $nombre,$tipo_documento,$num_documento,$direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen,$_POST['permiso']);
            echo $respuesta ? "usuario Editada" : "usuario no se pudo Editar";
        }
        break;

    case 'desactivar':
        $respuesta = $usuario->desactivar($idusuario);
        echo $respuesta ? "usuario Desactivada" : "usuario no se pudo Desactivar";
        break;

    case 'activar':
        $respuesta = $usuario->activar($idusuario);
        echo $respuesta ? "usuario Activada" : "usuario no se pudo Activar";
        break;

    case 'mostrar':
        $respuesta = $usuario->mostrar($idusuario);
        echo json_encode($respuesta);
        break;

    case 'listar':
        $respuesta = $usuario->listar();
        $data = array();
        while ($resp = $respuesta->fetch_object()) {
            $data[] = array(
                "0" => ($resp->condicion) ? '<button class="btn btn-warning m-1" onclick="mostrar(' . $resp->idusuario . ')"><i class="fas fa-info-circle"></i></button>' .
                '<button class="btn btn-danger m-1" onclick="desactivar(' . $resp->idusuario . ')"><i class="fas fa-times"></i></button>' :
                '<button class="btn btn-warning m-1" onclick="mostrar(' . $resp->idusuario . ')"><i class="fas fa-info-circle"></i></button>' .
                '<button class="btn btn-success m-1" onclick="activar(' . $resp->idusuario . ')"><i class="fas fa-check"></i></button>',
                "1" => $resp->nombre,
                "2" => $resp->tipo_documento,
                "3" => $resp->num_documento,
                "4" => $resp->telefono,
                "5" => $resp->email,
                "6" => $resp->login,
                "7"=>"<img src='../files/usuarios/".$resp->imagen."' height='50px' width='50px'>",
                "8" => ($resp->condicion) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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

    case 'permisos':
        require_once("../models/Permiso.php");
        $permiso = new Permiso();

        $resp = $permiso->listar();

        $id=$_GET['id'];

        $marcados = $usuario->listarmarcados($id);

        $valores=array();
        while ($per = $marcados->fetch_object()) {
            array_push($valores, $per->idpermiso);
        }

        while ($reg = $resp->fetch_object()) {
            $sw=in_array($reg->idpermiso,$valores)?'checked':'';

            echo '<li> <input type="checkbox" class="mx-3" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
        }

    case 'verificar':

        $clavehash=hash("SHA256",$clave);

        $respuesta = $usuario->verificar($login, $clavehash);
        $fetch=$respuesta->fetch_object();
        if (isset($fetch)) {
            $_SESSION['idusuario']=$fetch->idusuario;
	        $_SESSION['nombre']=$fetch->nombre;
	        $_SESSION['imagen']=$fetch->imagen;
	        $_SESSION['login']=$fetch->login;

            $marcados = $usuario->listarmarcados($fetch->idusuario);
            $valores=array();
            while ($per = $marcados->fetch_object()) {
                array_push($valores, $per->idpermiso);
            }
        }

        in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
		in_array(2,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
		in_array(3,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
		in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
		in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
		in_array(6,$valores)?$_SESSION['permisos']=1:$_SESSION['permisos']=0;

        echo json_encode($fetch);
        break;
}
?>