<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periodo;
use App\Http\Requests\StorePeriodos;

class PeriodoController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:periodos.index')->only('index');
        $this->middleware('can:periodos.create')->only('create','store');
        $this->middleware('can:periodos.edit')->only('edit','update');
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
                $periodos = Periodo::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $periodos = Periodo::where('anio', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $periodos = Periodo::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('periodo.index', ['periodos'=> $periodos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('periodo.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StorePeriodos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $periodo = new Periodo();
        $periodo->anio = $validated['anio'];
        $periodo->mes = $validated['mes'];
        $periodo->save();

        $request->session()->flash('status','Periodo creado correctamente');
        return redirect()->route('periodos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $periodo = Periodo::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('periodo.edit',['periodo'=> $periodo,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StorePeriodos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $periodo = Periodo::findOrFail($id);
        $periodo->anio = $validated['anio'];
        $periodo->mes = $validated['mes'];
        $periodo->save();

        $request->session()->flash('status','Periodo actualizado correctamente');
        return redirect()->route('periodos.edit',['periodo'=> $periodo,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
