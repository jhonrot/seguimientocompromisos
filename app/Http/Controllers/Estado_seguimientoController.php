<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado_seguimiento;
use App\Http\Requests\StoreEstado_seguimientos;

class Estado_seguimientoController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:estado_seguimientos.index')->only('index');
        $this->middleware('can:estado_seguimientos.create')->only('create','store');
        $this->middleware('can:estado_seguimientos.edit')->only('edit','update');
    }

    public function search(){
        $estados = Estado_seguimiento::all();

        return json_encode($estados);
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
                $est_seg = Estado_seguimiento::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $est_seg = Estado_seguimiento::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $est_seg = Estado_seguimiento::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('estado_seguimiento.index', ['est_segs'=> $est_seg,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('estado_seguimiento.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreEstado_seguimientos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $est_seg = new Estado_seguimiento();
        $est_seg->name = $validated['name'];
        $est_seg->save();

        $request->session()->flash('status','Estado seguimiento creado correctamente');
        return redirect()->route('estado_seguimientos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $est_seg = Estado_seguimiento::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('estado_seguimiento.edit',['est_seg'=> $est_seg,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreEstado_seguimientos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $est_seg = Estado_seguimiento::findOrFail($id);
        $est_seg->name = $validated['name'];
        $est_seg->save();

        $request->session()->flash('status','Estado seguimiento actualizado correctamente');
        return view('estado_seguimiento.edit',['est_seg'=> $est_seg,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
