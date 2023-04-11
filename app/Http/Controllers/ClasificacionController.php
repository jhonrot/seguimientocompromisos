<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clasificacion;
use App\Indice;
use App\Http\Requests\StoreClasificaciones;

class ClasificacionController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:clasificaciones.index')->only('index');
        $this->middleware('can:clasificaciones.create')->only('create','store');
        $this->middleware('can:clasificaciones.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function search(){
        $clasificaciones = Clasificacion::all();
        return json_encode($clasificaciones);
    }

    public function search_item($item){
        $clasificaciones = Clasificacion::where('indice_id', '=', $item)->get();

        return json_encode($clasificaciones);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $clasif = Clasificacion::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $clasif = Clasificacion::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $clasif = Clasificacion::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('clasificacion.index', ['clasif'=> $clasif,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        $indices = Indice::all();

        return view('clasificacion.create',['indices'=>$indices,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreClasificaciones $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $clasif = new Clasificacion();
        $clasif->name = $validated['name'];
        $clasif->description = $validated['description'];
        $clasif->indice_id = $validated['indice_id'];
        $clasif->save();

        $request->session()->flash('status','Clasificación creada correctamente');
        return redirect()->route('clasificaciones.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $clasif = Clasificacion::findOrFail($id);
        $indices = Indice::all();
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('clasificacion.edit',['indices'=>$indices,'clasif'=> $clasif,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreClasificaciones $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $clasif = Clasificacion::findOrFail($id);
        $clasif->name = $validated['name'];
        $clasif->description = $validated['description'];
        $clasif->indice_id = $validated['indice_id'];
        $clasif->save();

        $request->session()->flash('status','Clasificación actualizada correctamente');
        return redirect()->route('clasificaciones.edit',['clasificacione'=> $clasif,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
