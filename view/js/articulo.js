var tabla;

function init() {
    mostrarelformulario(false);
    listar();
    llenarSelectCategoria();
    $("#imagenmuestra").hide();

    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    })
}

function limpiar() {
  $("#nombre").val("");
  $("#descripcion").val("");
  $("#idcategoria").val("");
  $("#imagenmuestra").attr("src","");
  $("#imagenactual").val("");
  $("#print").hide();
  $("#idarticulo").val("");
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
        url: "../controllers/articulo.php?op=listar",
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
        url: "../controllers/articulo.php?op=guardareditar",
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

function mostrar(idarticulo){
    $.post("../controllers/articulo.php?op=mostrar", {idarticulo: idarticulo}, function(data, status){
        data = JSON.parse(data);
        mostrarelformulario(true);
        $("#idcategoria").val(data.idcategoria);
        $("#nombre").val(data.nombre);
        $("#codigo").val(data.codigo);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#imagenactual").val(data.imagen);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src","../files/articulos/"+data.imagen)
        $("#idarticulo").val(data.idarticulo);
        generabarcode();
    });
}

function desactivar(idarticulo){
    swal.fire({
      title: "CRUD",
      text: "¿Esta seguro de Desactivar el articulo?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.post("../controllers/articulo.php?op=desactivar",{ idarticulo: idarticulo },function (data) {
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

function activar(idarticulo){
    swal.fire({
      title: "CRUD",
      text: "¿Esta seguro de Activar la articulo?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.post("../controllers/articulo.php?op=activar",{ idarticulo: idarticulo },function (data) {
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

function llenarSelectCategoria(){
  $.post("../controllers/categoria.php?op=combo", function (data) {
    $("#idcategoria").html(data);
  });
}

function generabarcode(){
  codigo = $("#codigo").val();
  JsBarcode("#barcode", codigo);

  $("#print").show();

}

init();
