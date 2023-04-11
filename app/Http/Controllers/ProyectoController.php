<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Comuna;
use App\Organismo;
use App\User;
use App\Http\Requests\StoreProyectos;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware(['permission:proyectos.index|proyectos_assig.index'])->only('index');
        $this->middleware('can:proyectos.create')->only('create','store');
        $this->middleware(['permission:proyectos.edit|proyectos_assig.edit'])->only('edit','update');
        $this->middleware(['permission:paas.index|contractuals.index|ejecucions.index'])->only('registry');       
    }

    public function search(){
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('proyectos.index');
        $permiso2 = Auth::user()->hasPermissionTo('proyectos_assig.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $projs = Proyecto::all();
            return json_encode($projs);
        }
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $projs = Proyecto::where('user_id', '=', $this->id_user)->get();
            return json_encode($projs);
        }
    }

    public function registry(){
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        $proj  = $_GET['proj'];

        return view('proyecto.registry',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'proj'=>$proj]);
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

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('proyectos.index');
        $permiso2 = Auth::user()->hasPermissionTo('proyectos_assig.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;

            if($select_search != null){
                if($select_search == 1){
                    $proj = Proyecto::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 2){
                        $proj = Proyecto::where('bp', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 3 && $data_search != ""){
                            $proj = Proyecto::where('organismo_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                        }else{
                            if($select_search == 4 && $data_search != ""){
                                $proj = Proyecto::where('user_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                            }else{
                                $proj = Proyecto::orderBy('id','desc')->paginate(20)->withQueryString();
                            }
                        }
                    }
                }
            }else{
                $select_search = '1';
                $proj = Proyecto::orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;

            if($select_search != null){
                if($select_search == 1){
                    $proj = Proyecto::where('name', 'like', '%'.$data_search.'%')
                                    ->where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 2){
                        $proj = Proyecto::where('bp', 'like', '%'.$data_search.'%')
                                        ->where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 3 && $data_search != ""){
                            $proj = Proyecto::where('organismo_id', '=', $data_search)
                                            ->where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
                        }else{
                            if($select_search == 4 && $data_search != ""){
                                $proj = Proyecto::where('user_id', '=', $data_search)
                                                ->where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();    
                            }else{
                                $proj = Proyecto::where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
                            }
                        }
                    }
                }
            }else{
                $select_search = '1';
                $proj = Proyecto::where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('proyecto.index', ['projs'=> $proj,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $comunas = Comuna::all();
        $organismos = Organismo::all();
        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();
       
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('proyecto.create',['comunas'=>$comunas,'organismos'=>$organismos,'responsables'=>$responsables,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreProyectos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $proj = new Proyecto();
        $proj->name = $validated['name'];
        $proj->bp = $validated['bp'];
        $proj->comuna_id = $validated['comuna_id'];
        $proj->organismo_id = $validated['organismo_id'];
        $proj->user_id = $validated['user_id'];
        $proj->save();

        $request->session()->flash('status','Proyecto creado correctamente');
        return redirect()->route('proyectos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('proyectos.index');
        $permiso2 = Auth::user()->hasPermissionTo('proyectos_assig.index');
        $enter_if = 0;

        $comunas = Comuna::all();
        $organismos = Organismo::all();
        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $proj = Proyecto::findOrFail($id);
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $proj = Proyecto::where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $proj = $proj[0];
        }

        if($enter_if == 1 && isset($proj->id)){
            return view('proyecto.edit',['comunas'=>$comunas,'organismos'=>$organismos,'responsables'=>$responsables,'proj'=> $proj,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        } 
    }

    public function update(StoreProyectos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('proyectos.index');
        $permiso2 = Auth::user()->hasPermissionTo('proyectos_assig.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $validated = $request->validated();

            $proj = Proyecto::findOrFail($id);
            $proj->name = $validated['name'];
            $proj->bp = $validated['bp'];
            $proj->comuna_id = $validated['comuna_id'];
            $proj->organismo_id = $validated['organismo_id'];
            $proj->user_id = $validated['user_id'];
            $proj->save();

            $request->session()->flash('status','Proyecto actualizado correctamente');
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $validated = $request->validated();

            $proj = Proyecto::where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $proj = $proj[0];

            $proj->name = $validated['name'];
            $proj->bp = $validated['bp'];
            $proj->comuna_id = $validated['comuna_id'];
            $proj->organismo_id = $validated['organismo_id'];
            $proj->user_id = $validated['user_id'];
            $proj->save();

            $request->session()->flash('status','Proyecto actualizado correctamente');
        }

        if($enter_if == 1 && isset($proj->id)){
            return redirect()->route('proyectos.edit',['proyecto'=> $proj,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
        }else{
            return view("error.Error403");
        }
    }
}
