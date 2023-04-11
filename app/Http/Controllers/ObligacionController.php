<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Objetivo;
use App\Obligacion;
use App\Http\Requests\StoreObligaciones;

class ObligacionController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:obligaciones.index')->only('index');
        $this->middleware('can:obligaciones.create')->only('create','store');
        $this->middleware('can:obligaciones.edit')->only('edit','update');
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
                $obligaciones = Obligacion::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $obligaciones = Obligacion::where('obligacion', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $obligaciones = Obligacion::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('obligacion.index', ['obligaciones'=> $obligaciones,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $objetivos = Objetivo::all();
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('obligacion.create',['objetivos'=>$objetivos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreObligaciones $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $obligacion = new Obligacion();
        $obligacion->obligacion = $validated['obligacion'];
        $obligacion->objetivo_id = $validated['objetivo_id'];
        $obligacion->save();

        $request->session()->flash('status','Obligación creada correctamente');
        return redirect()->route('obligaciones.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $objetivos = Objetivo::all();

        $obligacion = Obligacion::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('obligacion.edit',['objetivos'=>$objetivos,'obligacion'=> $obligacion,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreObligaciones $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $obligacion = Obligacion::findOrFail($id);
        $obligacion->obligacion = $validated['obligacion'];
        $obligacion->objetivo_id = $validated['objetivo_id'];
        $obligacion->save();

        $request->session()->flash('status','Obligacion actualizada correctamente');
        return redirect()->route('obligaciones.edit',['obligacione'=> $obligacion,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
