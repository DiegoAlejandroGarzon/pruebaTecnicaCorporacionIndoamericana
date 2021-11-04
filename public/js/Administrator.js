$(document).ready(function(){
    //Creando token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var tablaCarnets = $('#tablaCarnets').DataTable({
        responsive: false,
        "ajax":"/obtenerInformacionCarnets",
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "columns":[
            {'defaultContent':''},
            {data:'nombre'},
            {data:'correo'},
            {data:'estado'},
            {'defaultContent' :'<center><button type="button" class="verCarnet btn btn-primary btn-sm" data-toggle="modal" data-target="#modal">VER</button></center>'},
        ],
        'createdRow':function(row, data, index){
            $('td', row).eq(3).prop("class", "estado");
            if(data.estado == 'DESAPROBADO'){
                $('td', row).eq(3).css({
                    'background-color':'#FF8B8B',
                    'text-align':'center',
                        'color':'Black'
                })
                html_select = '<select class="estado" name="estado"><option value="DESAPROBADO">DESAPROBADO</option><option value="PENDIENTE">PENDIENTE</option><option value="APROBADO">APROBADO</option></select>'
                $('td', row).eq(3).html(html_select);
            }
            if(data.estado == 'PENDIENTE'){
                $('td', row).eq(3).css({
                    'background-color':'#F1FF8B',
                    'text-align':'center',
                    'color':'Black'
                })
                html_select = '<select class="estado" name="estado"><option value="PENDIENTE">PENDIENTE</option><option value="APROBADO">APROBADO</option><option value="DESAPROBADO">DESAPROBADO</option></select>'
                $('td', row).eq(3).html(html_select);
            }
            if(data.estado == 'APROBADO'){
                $('td', row).eq(3).css({
                    'background-color':'#8BFF96',
                    'text-align':'center',
                    'color':'Black'
                })
                html_select = '<select class="estado" name="estado"><option value="APROBADO">APROBADO</option><option value="PENDIENTE">PENDIENTE</option><option value="DESAPROBADO">DESAPROBADO</option></select>'
                $('td', row).eq(3).html(html_select);
            }
        },
        'language': {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",              
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        }
        
    });
    
//CARGANDO NUMERACIOND DE TABLA
    tablaCarnets.on('order.dt search.dt', function () {
        tablaCarnets.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            tablaCarnets.cell(cell).invalidate('dom');
        });
    }).draw();

    $('#tablaCarnets tbody').on('click','button.verCarnet', function(e){
        //var usuarionEditar = tablaUsuario.row($(this)).data().id;
        var path = tablaCarnets.row(($(this)).parents("tr")).data().path;
        var html_select ="";
        console.log(path);
        html_select +="<img src='"+path+"' width='100%' height='100%' style='text-align: center;' ></img><br>";

        $('#visualizarCarnet').html(html_select);
    })
    

    $('#tablaCarnets tbody').on('change','td.estado', function(e){
        
        var idEstudiante = tablaCarnets.row(($(this)).parents("tr")).data().id;
        var datas = new FormData();
        datas.append("id",idEstudiante);
        datas.append("estado",$("select[name=estado]").val());
        $.ajax({
            "dataSrc":"data",
            type:'POST',
            url:"/cambioDeEstado",
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
        tablaCarnets.ajax.reload();
    })
});