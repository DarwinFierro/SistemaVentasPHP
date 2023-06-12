var tabla;

function init() {
    listar();
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
        url: "../controllers/permiso.php?op=listar",
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

init();
