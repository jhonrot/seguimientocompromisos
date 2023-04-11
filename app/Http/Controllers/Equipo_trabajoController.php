<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipo_trabajo;
use App\Organismo;
use App\Http\Requests\StoreEquipo_trabajos;

class Equipo_trabajoController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:equipos.index')->only('index');
        $this->middleware('can:equipos.create')->only('create','store');
        $this->middleware('can:equipos.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }
    
    public function search(){
        $equipos = Equipo_trabajo::all();
        return json_encode($equipos);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $et = Equipo_trabajo::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $et = Equipo_trabajo::where('descripcion', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $et = Equipo_trabajo::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);

        return view('equipo.index', ['ets'=> $et,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        
        $organismos = Organismo::all();

        return view('equipo.create',['organismos'=>$organismos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreEquipo_trabajos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $et = new Equipo_trabajo();
        $et->descripcion = $validated['descripcion'];
        $et->organismo_id = $validated['organismo_id'];
        $et->save();

        $request->session()->flash('status','Equipo de trabajo creado correctamente');

        return redirect()->route('equipos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $et = Equipo_trabajo::findOrFail($id);
        $organismos = Organismo::all();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('equipo.edit',['organismos'=>$organismos,'et'=> $et,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreEquipo_trabajos $request, $id)
    {
        $validated = $request->validated();
        
        $datos = explode(";", trim($request->get('url')));

        $et = Equipo_trabajo::findOrFail($id);
        $et->descripcion = $validated['descripcion'];
        $et->organismo_id = $validated['organismo_id'];
        $et->save();

        $request->session()->flash('status','Equipo de trabajo actualizado correctamente');

        return redirect()->route('equipos.edit',['equipo'=> $et,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

}
