$("#formulariologin").on("submit", function(e){
    e.preventDefault();

    login=$("#login").val();
    clave=$("#clave").val();

    $.post("../controllers/usuario.php?op=verificar", {"login":login, "clave":clave},function(data){
        data = JSON.parse(data);
        console.log(data);
        if (data!=null) {
            // Redirigir a la página correspondiente después de la verificación exitosa
            $(location).attr("href","categoria.php");
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Usuario y/o contraseña incorrectos!',
            })
        }
    })
})