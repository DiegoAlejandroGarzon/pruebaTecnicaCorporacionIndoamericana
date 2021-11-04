$(document).ready(function(){
    //Creando token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.get('comprobarSiHaSubidoFoto', function(data){
        
        $('#estadoDeLaFoto').html(data);
    });

    $('#subirCarnet').click(function(e){
        console.log($("#fileCarnet")[0].files.length);
        if($("#fileCarnet")[0].files.length == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No se encuentra un archivo subido',
            })
        }else{
            var file = $("#fileCarnet")[0].files;
            var datas = new FormData();
            datas.append('fileCarnet',file[0]);

            $.ajax({
                "dataSrc":"data",
                type:'POST',
                url:"/subirCarnet",
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
                }
            })
        }
    });

    //VALIDAR QUE CUALQUIER DOCUMENTO SUBIDO SEA EN IMAGEN
    $(document).on('change','input[type="file"]',function(){
        var fileName = this.files[0].name;
        var fileSize = this.files[0].size;
        var ext = fileName.split('.').pop();
        if(this.files.length != 1){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Recuerda que debes subir solo 1 archivo',
                footer: 'Vuelve a ingresar un archivo'
            })
            this.files[0].name = '';
            this.value = ''; // reset del valor
            
        }else{
            switch (ext) {
            case 'jpg':
                break;
            case 'png':
                break;
            case 'jpeg':
                break;
            case 'gif':
                break;
            case 'bmp':
                break;
            default:
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El Archivo no posee formato permitido',
                    footer: 'Vuelve a ingresar un archivo'
                })
                this.files[0].name = '';
                this.value = ''; // reset del valor
                break;
            }
        }
    });
});