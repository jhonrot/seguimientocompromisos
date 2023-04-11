<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proceso;
use App\Http\Requests\StoreProcesos;

class ProcesoController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:procesos.index')->only('index');
        $this->middleware('can:procesos.create')->only('create','store');
        $this->middleware('can:procesos.edit')->only('edit','update');
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
                $procesos = Proceso::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $procesos = Proceso::where('proceso', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $procesos = Proceso::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('proceso.index', ['procesos'=> $procesos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('proceso.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreProcesos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $proceso = new Proceso();
        $proceso->proceso = $validated['proceso'];
        $proceso->descripcion = $validated['descripcion'];
        $proceso->save();

        $request->session()->flash('status','Proceso creado correctamente');
        return redirect()->route('procesos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $proceso = Proceso::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('proceso.edit',['proceso'=> $proceso,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreProcesos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $proceso = Proceso::findOrFail($id);
        $proceso->proceso = $validated['proceso'];
        $proceso->descripcion = $validated['descripcion'];
        $proceso->save();

        $request->session()->flash('status','Proceso actualizado correctamente');
        return view('proceso.edit',['proceso'=> $proceso,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
