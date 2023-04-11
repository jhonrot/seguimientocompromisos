<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tema_despacho;
use App\Http\Requests\StoreTema_despachos;
use App\Tema_despacho_archivo;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Asistente;

class Tema_despachoController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware(['permission:tema_despachos.index|tema_despachos_create.index'])->only('index');
        $this->middleware('can:tema_despachos.create')->only('create','store');
        $this->middleware(['permission:tema_despachos.edit|tema_despachos_create.edit'])->only('edit','update');
        $this->middleware(['permission:tema_despachos.destroy|tema_despachos_create.destroy'])->only('confirmDelete','destroy');
        $this->middleware('can:tema_despachos.show')->only('show');
    }
    
    public function print_data($item1, $item2, $item3){
        if($item1 == 1){
            $reunion = Tema_despacho::all();
        }else{
            if($item1 == 2){
                $reunion = Tema_despacho::whereBetween('fecha_reunion', [$item2, $item3])->get();
            }else{
                $reunion = Tema_despacho::where('id', '=', $item2)->get();
            }
        }
    
        $pdf = PDF::loadView('tema_despacho.tema_despachoprint',['reunion'=>$reunion]);
        return $pdf->stream('Reunion'.$item1.'.pdf');
    }

    public function search(){
        $temas = Tema_despacho::all();
        return json_encode($temas);
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function index(Request $request)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('tema_despachos.index');
        $permiso2 = Auth::user()->hasPermissionTo('tema_despachos_create.index');
        $enter_if = 0;
        
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $temas = Tema_despacho::where('descripcion', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $temas = Tema_despacho::where('objetivo', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }
            }else{
                $select_search = '1';
                $temas = Tema_despacho::orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $temas = Tema_despacho::where('descripcion', 'like', '%'.$data_search.'%')->where('user_id', '=', $this->id_user)
                    ->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $temas = Tema_despacho::where('objetivo', 'like', '%'.$data_search.'%')->where('user_id', '=', $this->id_user)
                    ->orderBy('id','desc')->paginate(20)->withQueryString();
                }
            }else{
                $select_search = '1';
                $temas = Tema_despacho::where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }
        
        if($enter_if == 1 && isset($temas)){
            $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
            return view('tema_despacho.index', ['temas'=> $temas,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('tema_despacho.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreTema_despachos $request) 
    {
        $this->id_user = Auth::user()->id;
        
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();
        
        $thems = new Tema_despacho();
        $thems->descripcion = $validated['descripcion'];
        $thems->fecha_reunion = $validated['fecha_reunion'];
        $thems->hora_reunion = $validated['hora_reunion'];
        $thems->objetivo = $validated['objetivo'];
        $thems->asistentes = $validated['asistentes'];
        $thems->orden = $validated['orden'];
        $thems->desarrollo = $validated['desarrollo'];
        $thems->user_id = $this->id_user;
        $thems->estado = $validated['estado'];
        $thems->save();
        
        $datos_asistentes = json_decode($validated['asistentes']);
        $cant_asistentes = ($datos_asistentes==null?0:count($datos_asistentes));
        
        $info_asistentes = "";
        for ($i=0;$i<$cant_asistentes;$i++){
            $info_asistentes .= $datos_asistentes[$i]->value.", ";
            $verify = Asistente::where('name_full', '=', $datos_asistentes[$i]->value)->get();
            
            if(count($verify) == 0){
                $asist = new Asistente();
                $asist->name_full =  $datos_asistentes[$i]->value;
                $asist->save();
            }
        }
        $thems = Tema_despacho::findOrFail($thems->id);
        $thems->asistentes = $info_asistentes;
        $thems->save();
        
        if($request->file('evidencia') != null){
            foreach ($validated['evidencia'] as $key => $file){
                $path = public_path() . '/evidencia';
                $fileName = "tema_despacho-".uniqid() . $file->getClientOriginalName();
                $file->move($path, $fileName);

                $evidencia = new Tema_despacho_archivo();
                $evidencia->tema_despacho_id =  intval($thems->id);
                $evidencia->evidencia =  $fileName;
                $evidencia->save();
            }
        }

        $request->session()->flash('status','Reunión creada correctamente');
        return redirect()->route('tema_despachos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('tema_despachos.edit');
        $permiso2 = Auth::user()->hasPermissionTo('tema_despachos_create.edit');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $thems = Tema_despacho::findOrFail($id);
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $thems = Tema_despacho::select('tema_despachos.*')->where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $thems = $thems[0];
        }

        if($enter_if == 1 && isset($thems->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $this->page  = $_GET['page'];

            return view('tema_despacho.edit',['thems'=> $thems,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function update(StoreTema_despachos $request, $id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('tema_despachos.edit');
        $permiso2 = Auth::user()->hasPermissionTo('tema_despachos_create.edit');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $validated = $request->validated();
            
            $datos = explode(";", trim($request->get('url')));
            
            $datos_asistentes = json_decode($validated['asistentes']);
            $cant_asistentes = ($datos_asistentes==null?0:count($datos_asistentes));
            
            $info_asistentes = "";
            for ($i=0;$i<$cant_asistentes;$i++){
                $info_asistentes .= $datos_asistentes[$i]->value.", ";
                $verify = Asistente::where('name_full', '=', $datos_asistentes[$i]->value)->get();
                
                if(count($verify) == 0){
                    $asist = new Asistente();
                    $asist->name_full =  $datos_asistentes[$i]->value;
                    $asist->save();
                }
            }
    
            $thems = Tema_despacho::findOrFail($id);
            $thems->descripcion = $validated['descripcion'];
            $thems->fecha_reunion = $validated['fecha_reunion'];
            $thems->hora_reunion = $validated['hora_reunion'];
            $thems->objetivo = $validated['objetivo'];
            $thems->asistentes = $info_asistentes;
            $thems->orden = $validated['orden'];
            $thems->desarrollo = $validated['desarrollo'];
            $thems->estado = $validated['estado'];
            $thems->save();
            
            Tema_despacho_archivo::where('tema_despacho_id','=',$id)->delete();
    
            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $evidencia = new Tema_despacho_archivo();
                    $evidencia->tema_despacho_id =  intval($id);
                    $evidencia->evidencia =  $input_evidence;
                    $evidencia->save();
                }
            }
    
            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);
    
                    $evidencia = new Tema_despacho_archivo();
                    $evidencia->tema_despacho_id =  intval($id);
                    $evidencia->evidencia =  $fileName;
                    $evidencia->save();   
                }
            }
    
            $request->session()->flash('status','Reunión actualizada correctamente');
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;

            $validated = $request->validated();
            
            $datos = explode(";", trim($request->get('url')));
            
            $datos_asistentes = json_decode($validated['asistentes']);
            $cant_asistentes = ($datos_asistentes==null?0:count($datos_asistentes));
            
            $info_asistentes = "";
            for ($i=0;$i<$cant_asistentes;$i++){
                $info_asistentes .= $datos_asistentes[$i]->value.", ";
                $verify = Asistente::where('name_full', '=', $datos_asistentes[$i]->value)->get();
                
                if(count($verify) == 0){
                    $asist = new Asistente();
                    $asist->name_full =  $datos_asistentes[$i]->value;
                    $asist->save();
                }
            }
 
            $thems = Tema_despacho::select('tema_despachos.*')->where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $thems = $thems[0];

            $thems->descripcion = $validated['descripcion'];
            $thems->fecha_reunion = $validated['fecha_reunion'];
            $thems->hora_reunion = $validated['hora_reunion'];
            $thems->objetivo = $validated['objetivo'];
            $thems->asistentes = $info_asistentes;
            $thems->orden = $validated['orden'];
            $thems->desarrollo = $validated['desarrollo'];
            $thems->estado = $validated['estado'];
            $thems->save();

            Tema_despacho_archivo::where('tema_despacho_id','=',$id)->delete();

            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $evidencia = new Tema_despacho_archivo();
                    $evidencia->tema_despacho_id =  intval($id);
                    $evidencia->evidencia =  $input_evidence;
                    $evidencia->save();
                }
            }

            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);

                    $evidencia = new Tema_despacho_archivo();
                    $evidencia->tema_despacho_id =  intval($id);
                    $evidencia->evidencia =  $fileName;
                    $evidencia->save();   
                }
            }

            $request->session()->flash('status','Reunión actualizada correctamente');
        }
        
        if($enter_if == 1 && isset($thems->id)){
            return redirect()->route('tema_despachos.edit',['tema_despacho'=>$thems,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
        }else{
            return view("error.Error403");
        }
    }

    public function confirmDelete($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('tema_despachos.destroy');
        $permiso2 = Auth::user()->hasPermissionTo('tema_despachos_create.destroy');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $thems = Tema_despacho::findOrFail($id);
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $thems = Tema_despacho::select('tema_despachos.*')->where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $thems = $thems[0];
        }

        if($enter_if == 1 && isset($thems->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $this->page  = $_GET['page'];
        
            return view('tema_despacho.confirmDelete',['thems'=> $thems, 'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function destroy(Request $request,$id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('tema_despachos.destroy');
        $permiso2 = Auth::user()->hasPermissionTo('tema_despachos_create.destroy');
        $enter_if = 0;
        
        $datos = explode(";", trim($_POST['url']));
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $thems = Tema_despacho::findOrFail($id);
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $thems = Tema_despacho::select('tema_despachos.*')->where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $thems = $thems[0];
        }
        
        if($enter_if == 1 && isset($thems->id)){
            try {
                $thems->delete();
                $request->session()->flash('status','Reunión con id '.$id.' eliminado correctamente');
            }catch (\Illuminate\Database\QueryException $e) {
                $request->session()->flash('status','Reunión con id '.$id.' no se puede eliminar dado que varios seguimientos dependen de él');
            }

            return redirect()->route('tema_despachos.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);  
        }else{
            return view("error.Error403");
        }
    }

    public function show($id)
    {
        $thems = Tema_despacho::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('tema_despacho.show',['thems'=> $thems,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }
}
