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
                <h1 class="box-title">Permiso
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
                    <th>Nombre</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Nombre</th>
                  </tfoot>
                </table>
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

  <script src="js/permiso.js"></script>
</body>

</html>