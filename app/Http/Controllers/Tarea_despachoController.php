<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea_despacho;
use App\Indice;
use App\User;
use App\Tema;
use App\Tema_despacho;
use App\Sub_clasificacion;
use App\Equipo_trabajo;
use App\Http\Requests\StoreTarea_despachos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompromisoAsignado;
use App\Mail\CompromisoActualizado;

class Tarea_despachoController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware('can:tarea_despachos.index')->only('index');
        $this->middleware('can:tarea_despachos.create')->only('create','store');
        $this->middleware('can:tarea_despachos.edit')->only('edit','update');
        $this->middleware('can:tarea_despachos.show')->only('show');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $tareas = Tarea_despacho::where('descripcion', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                if($select_search == 2){
                    $tareas = Tarea_despacho::where('fecha_inicio', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 4){ //Organismo
                        $tareas = Tarea_despacho::join('temas','tarea_despachos.tema_id', '=', 'temas.id')
                                        ->join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                        ->join('indices','clasificaciones.indice_id', '=', 'indices.id')
                                        ->join('equipo_trabajos','indices.equipo_id', '=', 'equipo_trabajos.id')
                                        ->select('tarea_despachos.*')
                                        ->where('equipo_trabajos.organismo_id', '=', $data_search)
                                        ->orderBy('tarea_despachos.id','desc')->paginate(20)->withQueryString();                
                    }else{
                        if($select_search == 5){  //Equipo
                            $tareas = Tarea_despacho::join('temas','tarea_despachos.tema_id', '=', 'temas.id')
                                        ->join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                        ->join('indices','clasificaciones.indice_id', '=', 'indices.id')
                                        ->select('tarea_despachos.*')
                                        ->where('indices.equipo_id', '=', $data_search)
                                        ->orderBy('tarea_despachos.id','desc')->paginate(20)->withQueryString();

                        }else{
                            if($select_search == 6){   //Indice
                                $tareas = Tarea_despacho::join('temas','tarea_despachos.tema_id', '=', 'temas.id')
                                        ->join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                        ->select('tarea_despachos.*')
                                        ->where('clasificaciones.indice_id', '=', $data_search)
                                        ->orderBy('tarea_despachos.id','desc')->paginate(20)->withQueryString();

                            }else{
                                if($select_search == 7){   //Clasificación
                                    $tareas = Tarea_despacho::join('temas','tarea_despachos.tema_id', '=', 'temas.id')
                                            ->select('tarea_despachos.*')
                                            ->where('temas.clasificacion_id', '=', $data_search)
                                            ->orderBy('tarea_despachos.id','desc')
                                            ->paginate(20)->withQueryString();

                                }else{
                                    if($select_search == 8){  //Reeferencia transversal
                                        $tareas = Tarea_despacho::join('temas','tarea_despachos.tema_id', '=', 'temas.id')
                                                ->select('tarea_despachos.*')
                                                ->where('temas.subclasificacion_id', '=', $data_search)
                                                ->orderBy('tarea_despachos.id','desc')
                                                ->paginate(20)->withQueryString();
                                    }else{
                                        $tareas = Tarea_despacho::where('tema_despacho_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $select_search = '1';
            $tareas = Tarea_despacho::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);

        return view('tarea_despacho.index', ['tareas'=> $tareas,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create(Request $request)
    {
        $reunion = $request->get('tema');

        $them = Tema_despacho::select('descripcion', 'fecha_reunion')->where('id', '=', $reunion)->get();

        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();
        //$indices = Indice::all();
        
        $organismo_user_auth = Auth::user()->organismo_id;
        $sub_clasificaciones = Sub_clasificacion::all();
        $equipos = Equipo_trabajo::where('organismo_id', '=', $organismo_user_auth)->get();

        $tema = $_GET['tema'];
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('tarea_despacho.create',['responsables'=>$responsables,'equipos'=>$equipos,'sub_clasificaciones'=>$sub_clasificaciones,'them'=>$them,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'tema'=>$tema]);
    }

    public function store(StoreTarea_despachos $request) 
    {
        $this->id_user = Auth::user()->id;
        
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();
        
        $tema = new Tema();
        $tema->tema = $validated['tema'];
        $tema->description = $validated['descripcion'];
        $tema->fecha_cumplimiento = $validated['fecha_final'];
        $tema->estado_id = 1;
        $tema->equipo_id = $request->get('equipo_id');
        $tema->clasificacion_id = $request->get('clasificacion_id');
        $tema->subclasificacion_id = $request->get('subclasificacion_id');
        $tema->user_id = $this->id_user;
        $tema->save();

        $tema->users()->sync($request->get('user_id'));

        if($tema->id > 0){
            
            Mail::to($tema->asignador)->send(new CompromisoAsignado($tema));
            Mail::to($tema->users)->send(new CompromisoAsignado($tema));
            
            $tarea = new Tarea_despacho();
            $tarea->descripcion = $validated['descripcion'];
            $tarea->fecha_inicio = $validated['fecha_inicio'];
            $tarea->hora = $validated['hora'];
            $tarea->fecha_final = $validated['fecha_final'];
            $tarea->tema_id = $tema->id;
            $tarea->tema_despacho_id = $validated['tema_despacho_id'];
            $tarea->save();
            
            $request->session()->flash('status','Seguimiento del compromiso creado correctamente');
        }
        return redirect()->route('tarea_despachos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'tema'=>$request->get('tema_despacho_id')]);
    }

    public function edit($id)
    {
        $tarea = Tarea_despacho::findOrFail($id);

        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();
        //$indices = Indice::all();
        $organismo_user_auth = Auth::user()->organismo_id;
        $equipos = Equipo_trabajo::where('organismo_id', '=', $organismo_user_auth)->get();
        
        $sub_clasificaciones = Sub_clasificacion::all();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('tarea_despacho.edit',['responsables'=>$responsables,'equipos'=>$equipos,'sub_clasificaciones'=>$sub_clasificaciones,'tarea'=> $tarea,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreTarea_despachos $request, $id)
    {
        $validated = $request->validated();
        
        $datos = explode(";", trim($request->get('url')));

        $tarea = Tarea_despacho::findOrFail($id);
        $tarea->descripcion = $validated['descripcion'];
        $tarea->fecha_inicio = $validated['fecha_inicio'];
        $tarea->hora = $validated['hora'];
        $tarea->fecha_final = $validated['fecha_final'];
        $tarea->save();

        $tema = Tema::findOrFail($tarea->temas[0]->id);
        $tema->description = $request->get('descripcion');
        $tema->fecha_cumplimiento = $validated['fecha_final'];
        $tema->equipo_id = $request->get('equipo_id');
        $tema->clasificacion_id = $request->get('clasificacion_id');
        $tema->subclasificacion_id = $request->get('subclasificacion_id');
        $tema->save();
        
        $tema->users()->sync($request->get('user_id'));
        
        Mail::to($tema->asignador)->send(new CompromisoActualizado($tema, 1));
        Mail::to($tema->users)->send(new CompromisoActualizado($tema, 1));

        $request->session()->flash('status','Seguimiento del compromiso actualizado correctamente');
        
        return redirect()->route('tarea_despachos.edit',['tarea_despacho'=>$tarea,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    /*public function show($id)
    {
        $tarea = Tarea_despacho::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('tarea_despacho.show',['tarea'=> $tarea,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }*/

    public function confirmDelete($id)
    {
        $tarea = Tarea_despacho::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
    
        return view('tarea_despacho.confirmDelete',['tarea'=> $tarea, 'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function destroy(Request $request,$id)
    {
        $datos = explode(";", trim($_POST['url']));
        $tarea = Tarea_despacho::findOrFail($id);

        $tema = Tema::findOrFail($tarea->temas[0]->id);
        try {
            if(count($tema->seguimientos) == 0){
                $tarea->delete();
                $tema->delete();
                $request->session()->flash('status','Seguimiento del compromiso con id '.$id.' eliminado correctamente.');
            }else{
                $request->session()->flash('status','Seguimiento del compromiso con id '.$id.' no se pudo eliminar.');
            }
        }catch (\Illuminate\Database\QueryException $e) {
            $request->session()->flash('status','Seguimiento del compromiso con id '.$id.' no se pudo eliminar porque el compromiso tiene varias actividades que dependen de él');
        }
        return redirect()->route('tarea_despachos.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);  
    }
}
