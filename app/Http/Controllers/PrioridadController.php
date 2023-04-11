<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prioridad;
use App\Http\Requests\StorePrioridades;

class PrioridadController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:prioridades.index')->only('index');
        $this->middleware('can:prioridades.create')->only('create','store');
        $this->middleware('can:prioridades.edit')->only('edit','update');
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
                $prior = Prioridad::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $prior = Prioridad::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $prior = Prioridad::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('prioridad.index', ['prioridades'=> $prior,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('prioridad.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StorePrioridades $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $prior = new Prioridad();
        $prior->name = $validated['name'];
        $prior->save();

        $request->session()->flash('status','Prioridad creada correctamente');
        return redirect()->route('prioridades.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $prior = Prioridad::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('prioridad.edit',['prior'=> $prior,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StorePrioridades $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $prior = Prioridad::findOrFail($id);
        $prior->name = $validated['name'];
        $prior->save();

        $request->session()->flash('status','Prioridad actualizada correctamente');
        return view('prioridad.edit',['prior'=> $prior,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
