var tabla;

function init() {
    mostrarelformulario(false);
    listar();

    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    })
}

function limpiar() {
  $("#nombre").val("");
  $("#descripcion").val("");
  $("#idcategoria").val("");
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
        url: "../controllers/categoria.php?op=listar",
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

function guardaryeditar(e){
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../controllers/categoria.php?op=guardareditar",
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

function mostrar(idcategoria){
    $.post("../controllers/categoria.php?op=mostrar", {idcategoria: idcategoria}, function(data, status){
        data = JSON.parse(data);
        mostrarelformulario(true);

        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idcategoria").val(data.idcategoria);
    });
}

function desactivar(idcategoria){
    swal.fire({
      title: "CRUD",
      text: "¿Esta seguro de Desactivar la categoria?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.post("../controllers/categoria.php?op=desactivar",{ idcategoria: idcategoria },function (data) {
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

function activar(idcategoria){
    swal.fire({
      title: "CRUD",
      text: "¿Esta seguro de Activar la categoria?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.post("../controllers/categoria.php?op=activar",{ idcategoria: idcategoria },function (data) {
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
