<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sub_clasificacion;
use App\Http\Requests\StoreSub_clasificaciones;

class Sub_clasificacionController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:sub_clasificaciones.index')->only('index');
        $this->middleware('can:sub_clasificaciones.create')->only('create','store','form_create','form_store');
        $this->middleware('can:sub_clasificaciones.edit')->only('edit','update');
        $this->middleware('can:sub_clasificaciones.destroy')->only('confirmDelete','destroy');
    }
    
    public function form_create(Request $request){
        return view('sub_clasificacion.create_form');
    }

    public function form_store(StoreSub_clasificaciones $request) 
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();
        
        $sub_clasif = new Sub_clasificacion();
        $sub_clasif->name = $validated['name'];
        $sub_clasif->description = $validated['description'];
        $sub_clasif->save();

        $request->session()->flash('status','Referencia transversal creada correctamente');
        return redirect()->route('tarea_despachos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'tema'=>$datos[3]]);
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function search($item){
        $sub_clasificaciones = Sub_clasificacion::where('clasificacion_id', '=', $item)->get();

        return json_encode($sub_clasificaciones);
    }

    public function search_all(){
        $sub_clasificaciones = Sub_clasificacion::all();

        return json_encode($sub_clasificaciones);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $sub_clasif = Sub_clasificacion::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $sub_clasif = Sub_clasificacion::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $sub_clasif = Sub_clasificacion::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('sub_clasificacion.index', ['sub_clasif'=> $sub_clasif,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('sub_clasificacion.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreSub_clasificaciones $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $sub_clasif = new Sub_clasificacion();
        $sub_clasif->name = $validated['name'];
        $sub_clasif->description = $validated['description'];
        $sub_clasif->save();

        $request->session()->flash('status','Referencia transversal creada correctamente');
        return redirect()->route('sub_clasificaciones.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $sub_clasif = Sub_clasificacion::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('sub_clasificacion.edit',['sub_clasificacione'=>$sub_clasif,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreSub_clasificaciones $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $sub_clasif = Sub_clasificacion::findOrFail($id);
        $sub_clasif->name = $validated['name'];
        $sub_clasif->description = $validated['description'];
        $sub_clasif->save();

        $request->session()->flash('status','Referencia transversal actualizada correctamente');
        return redirect()->route('sub_clasificaciones.edit',['sub_clasificacione'=> $sub_clasif,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function confirmDelete($id)
    {
        $sub_clasif = Sub_clasificacion::findOrFail($id);
        
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
    
        return view('sub_clasificacion.confirmDelete',['sub_clasificacione'=> $sub_clasif, 'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function destroy(Request $request,$id)
    {
        $datos = explode(";", trim($_POST['url']));

        $sub_clasif = Sub_clasificacion::findOrFail($id);
    
        try {
            $sub_clasif->delete();
            $request->session()->flash('status','Referencia transversal con id '.$id.' eliminado correctamente');
        }catch (\Illuminate\Database\QueryException $e) {
            $request->session()->flash('status','Referencia transversal id '.$id.' no se puede eliminar dado que varias elementos que dependen de él');
        }

        return redirect()->route('sub_clasificaciones.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
