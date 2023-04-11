<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modalidad;
use App\Http\Requests\StoreModalidades;

class ModalidadController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:modalidades.index')->only('index');
        $this->middleware('can:modalidades.create')->only('create','store');
        $this->middleware('can:modalidades.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function search(){
        $mods = Modalidad::all();
        return json_encode($mods);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $mod = Modalidad::where('tipo', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $mod = Modalidad::where('tiempo', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $mod = Modalidad::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('modalidad.index', ['mods'=> $mod,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('modalidad.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreModalidades $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $mod = new Modalidad();
        $mod->tipo = $validated['tipo'];
        $mod->tiempo = $validated['tiempo'];
        $mod->save();

        $request->session()->flash('status','Modalidad creada correctamente');
        return redirect()->route('modalidades.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $mod = Modalidad::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('modalidad.edit',['mod'=> $mod,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreModalidades $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $mod = Modalidad::findOrFail($id);
        $mod->tipo = $validated['tipo'];
        $mod->tiempo = $validated['tiempo'];
        $mod->save();

        $request->session()->flash('status','Modalidad actualizada correctamente');
        return redirect()->route('modalidades.edit',['modalidade'=> $mod,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

}
