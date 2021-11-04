$(document).ready(function(){
    //Creando token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#editarUsuario').click(function(e){
        limpiarErrores();
        e.preventDefault();
        var datas = new FormData();
        datas.append("id",$("input[name=id]").val());
        datas.append("nombreCompleto",$("input[name=edicionnombreCompleto]").val());
        datas.append("correoElectronico",$("input[name=edicioncorreoElectronico]").val());
        sendData(datas);
    })
    
    function sendData(datas){
        $.ajax({
            "dataSrc":"data",
            type:'POST',
            url:"/editarUsuarioAutenticado",
            data:datas,
            processData:false,
            contentType:false,
            success:function(data){
                if(data.error == 'on'){
                    Swal.fire({
                        title:data.mensaje,
                        showConfirmButton: false,
                        icon:'error',
                        timer: 1500
                    })
                }else{
                    Swal.fire({
                        title:data.mensaje,
                        showConfirmButton: false,
                        icon:'success',
                        timer: 1500
                    })
                }
            },
            error:function(msj){
                var errores = msj.responseJSON.errors;
                for(var error in errores){
                    if(error=='nombreCompleto'){
                        $('#erroredicionNombreCompleto').html('<div class="limpiar alert alert-danger">'+errores[error]+"</div>");
                    }
                    if(error=='correoElectronico'){
                        $('#erroredicionCorreoElectronico').html('<div class="limpiar alert alert-danger">'+errores[error]+"</div>");
                    }

                }
            }
        })
    }
    //LIMPIAR MENSAJES DE ERRORES DEL FORMULARIO
    function limpiarErrores(){
        $('.limpiar').remove();
    }
});