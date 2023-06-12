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
  $("#num_documento").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#idpersona").val("");
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
        url: "../controllers/persona.php?op=listarProvedor",
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
        url: "../controllers/persona.php?op=guardareditar",
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

function mostrar(idpersona){
    $.post("../controllers/persona.php?op=mostrar", {idpersona: idpersona}, function(data, status){
        data = JSON.parse(data);
        console.log(data);
        mostrarelformulario(true);
        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento);
        $("#num_documento").val(data.num_documento);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#idpersona").val(data.idpersona);
    });
}

function eliminar(idarticulo){
    swal.fire({
      title: "CRUD",
      text: "¿Esta seguro de eliminar la persona?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.post("../controllers/persona.php?op=eliminar",{ idarticulo: idarticulo },function (data) {
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
