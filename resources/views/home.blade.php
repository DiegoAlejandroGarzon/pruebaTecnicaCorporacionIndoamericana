@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        <div id="estadoDeLaFoto"></div>
                        </div>
                    @endif

                    Hola {{Auth::user()->name}}
                    <br>
                    @role('Administrator')
                    
                        <table id="tablaCarnets" class="table display" >
                            <thead class="thead-dark">
                                <tr>
                                    <th ></th>
                                    <th >Nombre</th>
                                    <th >Correo</th>
                                    <th >Estado</th>
                                    <th >Carnet</th>
                                </tr>
                            </thead>
                            {{-- <tbody style="color:black"></tbody> --}}
                        </table>
                    
                        
                        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Foto del Carnet</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <div id="visualizarCarnet"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endrole
                    @role('Estudiante')
                        <h3>
                            <div id="estadoDeLaFoto"></div>
                        </h3>
                        Seleccione la foto que desea tener en su Carnet en formato imagen (jpg, png, etc.)
                        <form class="was-validated" id="formularioInscritos" enctype="multipart/form-data">
                            
                            <div class="custom-file">
                                <input type="file" name='fileCarnet' class="mb-3" id="fileCarnet"><br>
                            </div>
                        </form>
                        
                        <button type="button" class="btn btn-primary btn-lg btn-block" id="subirCarnet">Subir Foto</button>

                        
                    @endrole
                    
                </div>
            </div>
        </div>
    </div>
    
    @role('Estudiante')
    <script src="{{asset('js/carnet.js')}}"></script>
    @endrole
    @role('Administrator')
    <script src="{{asset('js/Administrator.js')}}"></script>
    @endrole
</div>
@endsection
