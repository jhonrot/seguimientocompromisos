<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Objetivo;
use App\Proceso;
use App\User;
use App\Http\Requests\StoreObjetivos;

class ObjetivoController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:objetivos.index')->only('index');
        $this->middleware('can:objetivos.create')->only('create','store');
        $this->middleware('can:objetivos.edit')->only('edit','update');
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
                $objetivos = Objetivo::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $objetivos = Objetivo::where('objetivo', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $objetivos = Objetivo::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('objetivo.index', ['objetivos'=> $objetivos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();
        
        $procesos = Proceso::all();
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('objetivo.create',['procesos'=>$procesos,'responsables'=>$responsables,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreObjetivos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $objetivo = new Objetivo();
        $objetivo->objetivo = $validated['objetivo'];
        $objetivo->proceso_id = $validated['proceso_id'];
        $objetivo->save();

        $objetivo->users()->sync($request->get('user_id'));

        $request->session()->flash('status','Objetivo creado correctamente');
        return redirect()->route('objetivos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();
        
        $procesos = Proceso::all();

        $objetivo = Objetivo::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('objetivo.edit',['procesos'=>$procesos,'responsables'=>$responsables,'objetivo'=> $objetivo,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreObjetivos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $objetivo = Objetivo::findOrFail($id);
        $objetivo->objetivo = $validated['objetivo'];
        $objetivo->proceso_id = $validated['proceso_id'];
        $objetivo->save();

        $objetivo->users()->sync($request->get('user_id'));

        $request->session()->flash('status','Objetivo actualizado correctamente');
        return redirect()->route('objetivos.edit',['objetivo'=> $objetivo,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
