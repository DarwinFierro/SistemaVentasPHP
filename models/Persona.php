<?php 
    require_once("../config/conection.php");

    class Persona{
        public function __construct(){

        }

        public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion, $telefono, $email){
            $sql="INSERT INTO persona(tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) 
            VALUES('$tipo_persona','$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email')";
            return ejecutarConsulta($sql);
        }

        public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion, $telefono, $email){
            $sql="UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre', tipo_documento='$tipo_documento', 
            num_documento='$num_documento', direccion='$direccion', telefono='$telefono', email='$email' WHERE idpersona='$idpersona'";
            return ejecutarConsulta($sql);
        }

        public function eliminar($idpersona){
            $sql="DELETE FROM persona WHERE idpersona='$idpersona'";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idpersona){
            $sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
            return ejecutarConsultaUnica($sql);
        }

        public function listarCliente(){
            $sql = "SELECT * FROM persona WHERE tipo_persona='clientes'";
            return ejecutarConsulta($sql);
        }

        public function listarProvedor(){
            $sql = "SELECT * FROM persona WHERE tipo_persona='provedor'";
            return ejecutarConsulta($sql);
        }
    }
?>