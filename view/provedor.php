<!DOCTYPE html>
<html lang="en">

<?php require_once("components/header.php") ?>

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
                <h1 class="box-title">Provedor <button class="btn btn-success" id="btnAgregar"
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
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Numero</th>
                    <th>telefono</th>
                    <th>email</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Numero</th>
                    <th>telefono</th>
                    <th>email</th>
                  </tfoot>
                </table>
              </div>

              <div class="card-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>nombre</label>
                        <input type="hidden" name="idpersona" id="idpersona">
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="escribir nombre"
                          required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="tipo_documento">Tipo Documento</label>
                        <select class="form-control" id="tipo_documento" name="tipo_documento">
                          <option value="RUC">ruc</option>
                          <option value="pasaporte">pasaporte</option>
                          <option value="dni">dni</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="descripcion">Numero Documento</label>
                        <input type="text" class="form-control" name="num_documento" id="num_documento"
                          placeholder="escribir Numero de documento" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Direccion</label>
                        <input type="text" class="form-control" name="direccion" id="direccion"
                          placeholder="escribir descripcion" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>telefono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono"
                          placeholder="escribir descripcion" required>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>email</label>
                        <input type="email" class="form-control" name="email" id="email"
                          placeholder="escribir descripcion" required>
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

    <?php require_once("components/footer.php") ?>
  </div>
  <!-- ./wrapper -->

  <script src="js/provedor.js"></script>
</body>

</html>