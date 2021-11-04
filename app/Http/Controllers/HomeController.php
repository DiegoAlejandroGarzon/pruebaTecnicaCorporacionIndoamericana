<?php

namespace App\Http\Controllers;

use App\estudiante;
use App\Http\Requests\edicionUsuarioRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function configuracionCuenta()
    {
        return view('configuracionCuenta');
    }
    
    public function editarUsuarioAutenticado(edicionUsuarioRequest $request){
        $usuarios = User::all();
        foreach ($usuarios as $user){
            if($user->id != $request->id){
                if($user->email == $request->correoElectronico){
                    return $data=[
                        'error'=>'on',
                        'mensaje'=>'Ya existe un usuario con el mismo correo',
                    ];
                }
            }
        }
        $usuario = User::find(Auth::user()->id);
        $usuario->name = $request->nombreCompleto;
        $usuario->email = $request->correoElectronico;

        if($usuario->save()){
            $data=[
                'mensaje'=>$request->nombreCompleto.' fue editado con éxito'
            ];
        }else{
            $data=[
                'error'=>'on',
                'mensaje'=>'no se pudo guardar correctamente',
            ];
        }
        return response()->json($data,200);
    }

    public function subirCarnet(Request $request){
        if($request->hasFile('fileCarnet')){
            $file = $request->fileCarnet;
            $nombre=$file->getClientOriginalName();
            $extension= explode('.',$nombre);
            $idDelUsuario = Auth::user()->id;
            if($extension[1]=='gif' || $extension[1]=='png' || $extension[1]=='jpg' || $extension[1]=='jpeg'|| $extension[1]=='bmp'){
                $file->move(public_path().'/carnets', 'carnetDelUsuarioConId'.$idDelUsuario.'.'.$extension[1]);
                $path = '/carnets/carnetDelUsuarioConId'.$idDelUsuario.'.'.$extension[1];
                
                if(estudiante::where('usuario_id', $idDelUsuario)->count() == 0){
                    $estudiante = new estudiante();
                    $estudiante->usuario_id = $idDelUsuario;
                    $estudiante->path_foto = $path;
                    $estudiante->estado = 'PENDIENTE';
                    $estudiante->save();
                }else{
                    $estudiante = estudiante::where('usuario_id', $idDelUsuario)->first();
                    $estudiante->estado = 'PENDIENTE';
                    $estudiante->path_foto = $path;
                    $estudiante->save();
                    $data = [
                        'error'=> false,
                        'mensaje' => 'El archivo se ha subido Exitosamente'
                    ];
                }
            }else{
                $data = [
                    'error'=> true,
                    'mensaje' => 'El archivo no tiene un formato permitido'
                ];
            }
        }else{
            $data = [
                'error'=> true,
                'mensaje' => 'No se encuentra un archivo subido'
            ];
        }
        return $data;
    }

    public function obtenerInformacionCarnets(){
        $carnets = estudiante::orderBy('updated_at', 'asc')->get();
        $concatenaTabla = collect([]);
        foreach($carnets as $carnet){
            $collection = collect([
                    [
                        'id' => $carnet->id,
                        'nombre' => User::find($carnet->usuario_id)->name,
                        'correo' =>User::find($carnet->usuario_id)->email,
                        'estado' =>$carnet->estado,
                        'path' =>$carnet->path_foto,
                    ]
            ]);
            $concatenaTabla = $collection->concat($concatenaTabla);
        }
        return response()->json(['data'=>$concatenaTabla],200);
    }
    
    public function cambioDeEstado(Request $request){
        $estudiante = estudiante::find($request->id);
        $estudiante->estado = $request->estado;
        if($estudiante->save()){
            $data = [
                'error'=> false,
                'mensaje' =>'Estado Cambiado Exitosamente'
            ];
        }else{
            $data = [
                'error'=> true,
                'mensaje' => 'Error al Cambiar de Estado'
            ];
        }
        return $data;
    }

    public function comprobarSiHaSubidoFoto(){
        $resultado = estudiante::where('usuario_id', Auth::user()->id)->count();
        if($resultado == 0){
            return "No se ha registrado ninguna foto para carnetización";
        }else{
            $carnet = estudiante::where('usuario_id', Auth::user()->id)->first();
            return "La ulima foto que ha subido tiene el estado ".$carnet->estado;
        }
    }
}
