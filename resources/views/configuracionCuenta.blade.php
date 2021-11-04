@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Configuracion de Cuenta</div>
                <div class="panel-body">
                    <div class="card shadow mb-4" id="divIngresarDatos" >
                        <div class="card-body py-3">
                            <form class="was-validated" id="formularioEditarUsuarios">
                                <input type="text" name="id" value="{{Auth::user()->id}}" hidden>
                                <div class="mb-3">
                                    <label for="edicionnombreCompleto">Nombre Completo</label><br>
                                    <input id="edicionnombreCompleto" name="edicionnombreCompleto" type="text" class="form-control" value='{{Auth::user()->name}}' required>
                                    <small class="form-text text-muted " id="erroredicionNombreCompleto" >
                                    </small>
                                </div>
                                <div class="mb-3">
                                    <label for="edicioncorreoElectronico">Correo Electronico</label><br>
                                    <input id="edicioncorreoElectronico" name="edicioncorreoElectronico" type="email" class="form-control" value='{{Auth::user()->email}}' required>
                                    <small class="form-text text-muted" id="erroredicionCorreoElectronico"></small>
                                </div>
                                <br>
                                <button type="button" class="btn btn-primary btn-lg btn-block" id="editarUsuario">Editar</button>
                            </form>
                            <br>
                            <div class="card shadow mb-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script rel="stylesheet" src="{{asset('js/editarUsuario.js')}}"></script>
@endsection
