<?php 
    require_once("../config/conection.php");

    class Articulo{
        public function __construct(){

        }

        public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen){
            $sql="INSERT INTO articulo(idcategoria, codigo, nombre, stock, descripcion, imagen, condicion) 
            VALUES('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
            return ejecutarConsulta($sql);
        }

        public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen){
            $sql="UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre', stock='$stock', descripcion='$descripcion', imagen='$imagen' WHERE idarticulo='$idarticulo'";
            return ejecutarConsulta($sql);
        }

        public function desactivar($idarticulo){
            $sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
            return ejecutarConsulta($sql);
        }
        public function activar($idarticulo){
            $sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idarticulo){
            $sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
            return ejecutarConsultaUnica($sql);
        }

        public function listar(){
            $sql = "SELECT 
            articulo.idarticulo, 
            articulo.idcategoria,
            articulo.codigo,
            articulo.nombre,
            articulo.stock,
            articulo.descripcion,
            articulo.imagen,
            articulo.condicion,
            categoria.nombre as cat_nombre
            FROM articulo INNER JOIN categoria on articulo.idcategoria = categoria.idcategoria";
            return ejecutarConsulta($sql);
        }
    }
?>