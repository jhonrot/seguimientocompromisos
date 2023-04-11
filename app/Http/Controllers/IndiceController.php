<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Indice;
use App\Equipo_trabajo;
use App\Http\Requests\StoreIndices;

class IndiceController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:indices.index')->only('index');
        $this->middleware('can:indices.create')->only('create','store');
        $this->middleware('can:indices.edit')->only('edit','update');
        $this->middleware('can:indices.destroy')->only('confirmDelete','destroy');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function search(){
        $indices = Indice::all();
        return json_encode($indices);
    }
    
    public function search_item($item){
        $indices = Indice::where('equipo_id', '=', $item)->get();

        return json_encode($indices);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $indices = Indice::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $indices = Indice::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $indices = Indice::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('indice.index', ['indices'=> $indices,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        
        $equipos = Equipo_trabajo::all();

        return view('indice.create',['equipos'=>$equipos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreIndices $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $indices = new Indice();
        $indices->name = $validated['name'];
        $indices->description = $validated['description'];
        $indices->equipo_id = $validated['equipo_id'];
        $indices->save();

        $request->session()->flash('status','Indice creado correctamente');
        return redirect()->route('indices.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $indice = Indice::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        
        $equipos = Equipo_trabajo::all();

        return view('indice.edit',['equipos'=>$equipos,'indice'=> $indice,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreIndices $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $indice = Indice::findOrFail($id);
        $indice->name = $validated['name'];
        $indice->description = $validated['description'];
        $indices->equipo_id = $validated['equipo_id'];
        $indice->save();

        $request->session()->flash('status','Indice actualizado correctamente');
        return view('indice.edit',['indice'=> $indice,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function confirmDelete($id)
    {
        $indice = Indice::findOrFail($id);
        
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
    
        return view('indice.confirmDelete',['indice'=> $indice, 'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function destroy(Request $request,$id)
    {

        $datos = explode(";", trim($_POST['url']));

        $indice = Indice::findOrFail($id);
    
        try {
            $indice->delete();
            $request->session()->flash('status','Indice con id '.$id.' eliminado correctamente');
        }catch (\Illuminate\Database\QueryException $e) {
            $request->session()->flash('status','Indice con id '.$id.' no se puede eliminar dado que varias clasificaciones dependen de él');
        }

        return redirect()->route('indices.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
