<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comuna;
use App\Http\Requests\StoreComunas;

class ComunaController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:comunas.index')->only('index');
        $this->middleware('can:comunas.create')->only('create','store');
        $this->middleware('can:comunas.edit')->only('edit','update');
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
                $com = Comuna::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $com = Comuna::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $com = Comuna::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('comuna.index', ['coms'=> $com,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('comuna.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreComunas $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $com = new Comuna();
        $com->name = $validated['name'];
        $com->save();

        $request->session()->flash('status','Comuna creada correctamente');
        return redirect()->route('comunas.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $com = Comuna::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('comuna.edit',['com'=> $com,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreComunas $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $com = Comuna::findOrFail($id);
        $com->name = $validated['name'];
        $com->save();

        $request->session()->flash('status','Comuna actualizada correctamente');
        return view('comuna.edit',['com'=> $com,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
