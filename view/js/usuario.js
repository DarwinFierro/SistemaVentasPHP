var tabla;

function init() {
  mostrarelformulario(false);
  listar();

  $("#imagenmuestra").hide();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  llenarPermisos();
}

function limpiar() {
  $("#nombre").val("");
  $("#num_documento").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#cargo").val("");
  $("#login").val("");
  $("#clave").val("");
  $("#imagenmuestra").attr("src", "");
  $("#imagenactual").val("");
  $("#idusuario").val("");
}

function mostrarelformulario(x) {
  limpiar();
  if (x) {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled", false);
    $("#btnAgregar").hide();
  } else {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnAgregar").show();
  }
}

function cancelarformulario() {
  limpiar();
  mostrarelformulario(false);
}

function listar() {
  tabla = $("#tablalistado")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      responsive: true,
      dom: "Bfrtip",
      buttons: ["copy", "excel", "csv"],
      ajax: {
        url: "../controllers/usuario.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 5, //Por cada 5 registros hace una paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .dataTable();
}

function guardaryeditar(e) {
  e.preventDefault();
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);
  $.ajax({
    url: "../controllers/usuario.php?op=guardareditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      mostrarelformulario(false);
      $("#tablalistado").DataTable().ajax.reload();

      swal.fire("Registro!", datos, "success");
    },
  });
}

function mostrar(idusuario) {
  $.post("../controllers/usuario.php?op=mostrar",{ idusuario: idusuario },function (data, status) {
      data = JSON.parse(data);
      mostrarelformulario(true);
      $("#nombre").val(data.nombre);
      $("#tipo_documento").val(data.tipo_documento);
      $("#num_documento").val(data.num_documento);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#cargo").val(data.cargo);
      $("#login").val(data.login);
      $("#imagenmuestra").show();
      $("#imagenmuestra").attr("src", "../files/usuarios/"+data.imagen);
      $("#imagenactual").val(data.imagen);
      $("#idusuario").val(data.idusuario);
    }
  );
  $.post("../controllers/usuario.php?op=permisos&id="+idusuario, function (data) {
    $("#permisos").html(data);
  });
}

function llenarPermisos() {
  $.post("../controllers/usuario.php?op=permisos&id=", function (data) {
    $("#permisos").html(data);
  });
}

function desactivar(idusuario){
  swal.fire({
    title: "CRUD",
    text: "¿Esta seguro de Desactivar el usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si",
    cancelButtonText: "No",
    reverseButtons: true,
  })
  .then((result) => {
    if (result.isConfirmed) {
      $.post("../controllers/usuario.php?op=desactivar",{ idusuario: idusuario },function (data) {
          $("#tablalistado").DataTable().ajax.reload();
          swal.fire("Deleted!", data, "success");
      });  
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
    }
  });
}

function activar(idusuario){
  swal.fire({
    title: "CRUD",
    text: "¿Esta seguro de Activar el usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si",
    cancelButtonText: "No",
    reverseButtons: true,
  })
  .then((result) => {
    if (result.isConfirmed) {
      $.post("../controllers/usuario.php?op=activar",{ idusuario: idusuario },function (data) {
          $("#tablalistado").DataTable().ajax.reload();
          swal.fire("Deleted!", data, "success");
      });  
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
    }
  });
}

init();
