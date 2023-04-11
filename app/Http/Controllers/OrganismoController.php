<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organismo;
use App\Http\Requests\StoreOrganismos;

class OrganismoController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:organismos.index')->only('index');
        $this->middleware('can:organismos.create')->only('create','store');
        $this->middleware('can:organismos.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function search(){
        $organismos = Organismo::all();
        return json_encode($organismos);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $org = Organismo::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $org = Organismo::where('name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $org = Organismo::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('organismo.index', ['orgs'=> $org,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('organismo.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreOrganismos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $org = new Organismo();
        $org->name = $validated['name'];
        $org->save();

        $request->session()->flash('status','Organismo creado correctamente');
        return redirect()->route('organismos.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $org = Organismo::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('organismo.edit',['org'=> $org,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreOrganismos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $org = Organismo::findOrFail($id);
        $org->name = $validated['name'];
        $org->save();

        $request->session()->flash('status','Organismo actualizado correctamente');
        return view('organismo.edit',['org'=> $org,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }
}
