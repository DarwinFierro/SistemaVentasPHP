var tabla;

function init() {
    mostrarelfromulario(false);
    listar();
}

function limpiar() {
  $("#nombre").val("");
  $("#descripcion").val("");
  $("#idcategoria").val("");
}

function mostrarelfromulario(x) {
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
  mostrarelfromulario(false);
}

function listar() {
  tabla = $("#tablalistado")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      buttons: ["copy", "excel", "csv"],
      ajax: {
        url: "../../controllers/categoria.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 5, //Por cada 10 registros hace una paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .dataTable();
}

init();
