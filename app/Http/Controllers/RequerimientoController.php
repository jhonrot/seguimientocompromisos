<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requerimiento;
use App\Http\Requests\StoreRequerimientos;
use Illuminate\Support\Facades\Auth;

class RequerimientoController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware(['permission:helps.index|helps_create.index'])->only('index');
        $this->middleware('can:helps.create')->only('create','store');
        $this->middleware('can:helps.edit')->only('edit','update');
        $this->middleware('can:helps.show')->only('show');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function index(Request $request)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('helps.index');
        $permiso2 = Auth::user()->hasPermissionTo('helps_create.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $select_search = $request->get('select_search');
            $data_search = trim($request->get('data_search'));
            if($select_search != null){
                if($select_search == 1){
                    $req = Requerimiento::where('tema', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $req = Requerimiento::where('state', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                }
            }else{
                $select_search = '1';
                $req = Requerimiento::orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $select_search = $request->get('select_search');
            $data_search = trim($request->get('data_search'));
            if($select_search != null){
                if($select_search == 1){
                    $req = Requerimiento::where('tema', 'like', '%'.$data_search.'%')
                                        ->where('user_id', '=', $this->id_user)
                                        ->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $req = Requerimiento::where('state', '=', $data_search)
                                        ->where('user_id', '=', $this->id_user)
                                        ->orderBy('id','desc')->paginate(20)->withQueryString();
                }
            }else{
                $select_search = '1';
                $req = Requerimiento::where('user_id', '=', $this->id_user)->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('requerimiento.index', ['reqs'=> $req,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('requerimiento.create',['select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreRequerimientos $request) 
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();
        
        $req = new Requerimiento();
        $req->user_id = Auth::user()->id;
        $req->state = 1;
        $req->tema = $validated['tema'];

        if($request->file('evidencia') != null){
            $file = $request->file('evidencia');
            $path = public_path() . '/evidencia';
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($path, $fileName);

            $req->evidencia = $fileName;
        }

        $req->obs_creator = $validated['obs_creator'];
        $req->save();

        //$soporte = Auth::user()->hasRole('soporte');

        $request->session()->flash('status','Requerimiento creado correctamente');
        return redirect()->route('helps.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('helps.index');
        $permiso2 = Auth::user()->hasPermissionTo('helps_create.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $req = Requerimiento::findOrFail($id);
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $req = Requerimiento::where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $req = $req[0];
        }

        if($enter_if == 1 && isset($req->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $this->page  = $_GET['page'];

            return view('requerimiento.edit',['req'=> $req,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function update(StoreRequerimientos $request, $id)
    {
        $validated = $request->validated();
        
        $datos = explode(";", trim($request->get('url')));

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('helps.index');
        $permiso2 = Auth::user()->hasPermissionTo('helps_create.index');
        $soporte = Auth::user()->hasRole('soporte');
        $enter_if = 0;




        if($permiso1 && $enter_if == 0){
            $enter_if = 1;

            $fileName = null;
            if($request->file('evidencia') != null){
                $file = $request->file('evidencia');
                $path = public_path() . '/evidencia';
                $fileName = uniqid() . $file->getClientOriginalName();
                $file->move($path, $fileName);
            }

            if($request->get('evidencia_inicial') != ''){
                $fileName = $request->get('evidencia_inicial');
            }

            $req = Requerimiento::findOrFail($id);

            if($req->user_id == $this->id_user){
                $req->tema = $validated['tema'];
                $req->obs_creator = $validated['obs_creator'];
                $req->evidencia = $fileName;
            }else{
                $req->state = $validated['state'];
                $req->obs_support = $validated['obs_support'];
            }
            
            $req->save();

            $request->session()->flash('status','Requerimiento actualizado correctamente');
        }





        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            
            $fileName = null;
            if($request->file('evidencia') != null){
                $file = $request->file('evidencia');
                $path = public_path() . '/evidencia';
                $fileName = uniqid() . $file->getClientOriginalName();
                $file->move($path, $fileName);
            }

            if($request->get('evidencia_inicial') != ''){
                $fileName = $request->get('evidencia_inicial');
            }
            
            $req = Requerimiento::where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $req = $req[0];

            if($req->user_id == $this->id_user){
                $req->tema = $validated['tema'];
                $req->obs_creator = $validated['obs_creator'];
                $req->evidencia = $fileName;
            }else{
                $req->state = $validated['state'];
                $req->obs_support = $validated['obs_support'];
            }
            
            $req->save();

            $request->session()->flash('status','Requerimiento actualizado correctamente');
        }

        if($enter_if == 1 && isset($req->id)){
            return view('requerimiento.edit',['req'=> $req,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
        }else{
            return view("error.Error403");
        }
    }

    /*public function show($id)
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('helps.index');
        $permiso2 = Auth::user()->hasPermissionTo('helps_create.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $req = Requerimiento::findOrFail($id);
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;

            $req = Requerimiento::where('id', '=', $id)->where('user_id', '=', $this->id_user)->get();
            $req = $req[0];
        }

        if($enter_if == 1 && isset($req->id)){
            return view('requerimiento.show',['req'=> $req,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
        }else{
            return view("error.Error403");
        }
    }*/
}
