<?php 
ob_start();
session_start();
if(!isset($_SESSION['nombre'])){
    header("Location: login.php");
}else{
  require_once("components/header.php");
  if($_SESSION['almacen'] == 1){
?>
<!DOCTYPE html>
<html lang="en">
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?php echo $ruta ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
        width="60">
    </div>

    <!-- Navbar -->
    <?php require_once("components/navbar.php") ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once("components/menu.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Articulo <button class="btn btn-success" id="btnAgregar"
                    onclick="mostrarelformulario(true)"><i class="fa fa-plus-circle"></i>
                    Agregar</button>
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tablalistado" class="table table-striped table-bordered table-condensed table-hover"
                  style="width: 100%;">
                  <thead>
                    <th>Opciones</th>
                    <th>categoria</th>
                    <th>Nombre</th>
                    <th>codigo</th>
                    <th>stock</th>
                    <th>Descripción</th>
                    <th>imagen</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>categoria</th>
                    <th>Nombre</th>
                    <th>codigo</th>
                    <th>stock</th>
                    <th>Descripción</th>
                    <th>imagen</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>

              <div class="card-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>nombre</label>
                        <input type="hidden" name="idarticulo" id="idarticulo">
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="escribir nombre"
                          required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="idcategoria">Categoria</label>
                        <select class="form-control" id="idcategoria" name="idcategoria">
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="descripcion">Descripcion</label>
                        <input type="text" class="form-control" name="descripcion" id="descripcion"
                          placeholder="escribir descripcion" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Subir Imagen</label>
                        <input type="file" class="form-control-file" name="imagen" id="imagen">
                        <input type="hidden" name="imagenactual" id="imagenactual">
                        <img src="" alt="" width="150px" height="120px" id="imagenmuestra">
                      </div>
                    </div>
                    

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Codigo</label>
                        <input type="text" class="form-control" name="codigo" id="codigo" required>
                        <button type="button" class="btn btn-block btn-success my-1" onclick="generabarcode()">Generar</button>
                        <div id="print">
                          <svg id="barcode"></svg>
                        </div>
                      </div>
                    </div>
                    
                  </div>



                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                      Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarformulario()" type="button"><i
                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>
              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->
</body>

</html>
<?php 
  }else {
    require 'noacceso.php';
  }
  require_once("components/footer.php");
  echo '<script src="js/articulo.js"></script>';
}
ob_end_flush();
?>