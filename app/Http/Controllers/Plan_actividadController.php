<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan_actividad;
use App\Obligacion;
use App\Unidad;
use App\Http\Requests\StorePlan_actividades;

class Plan_actividadController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:planes.index')->only('index');
        $this->middleware('can:planes.create')->only('create','store');
        $this->middleware('can:planes.edit')->only('edit','update');
        $this->middleware('can:planes.destroy')->only('confirmDelete','destroy');
        $this->middleware('can:planes.show')->only('show');
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
                $planes = Plan_actividad::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                $planes = Plan_actividad::where('actividad', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $planes = Plan_actividad::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('plan.index', ['planes'=> $planes,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $obligaciones = Obligacion::all();
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('plan.create',['obligaciones'=>$obligaciones,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StorePlan_actividades $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $plan = new Plan_actividad();
        $plan->actividad = $validated['actividad'];
        $plan->actividad_descripcion = $validated['actividad_descripcion'];
        $plan->meta = $validated['meta'];
        $plan->meta_descripcion = $validated['meta_descripcion'];
        $plan->indicador = $validated['indicador'];
        $plan->cantidad = $validated['cantidad'];
        $plan->obligacion_id = $validated['obligacion_id'];
        $plan->save();

        foreach ($validated['unidad'] as $key => $unit){
            $unidad = new Unidad();
            $unidad->plan_actividad_id =  intval($plan->id);
            $unidad->unidad =  $unit;
            $unidad->save();
        }

        $request->session()->flash('status','Actividad creada correctamente');
        return redirect()->route('planes.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $obligaciones = Obligacion::all();

        $plan = Plan_actividad::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('plan.edit',['obligaciones'=>$obligaciones,'plan'=> $plan,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StorePlan_actividades $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $plan = Plan_actividad::findOrFail($id);
        $plan->actividad = $validated['actividad'];
        $plan->actividad_descripcion = $validated['actividad_descripcion'];
        $plan->meta = $validated['meta'];
        $plan->meta_descripcion = $validated['meta_descripcion'];
        $plan->indicador = $validated['indicador'];
        $plan->cantidad = $validated['cantidad'];
        $plan->obligacion_id = $validated['obligacion_id'];
        $plan->save();

        Unidad::where('plan_actividad_id','=',$id)->delete();

        foreach ($validated['unidad'] as $key => $unit){
            $unidad = new Unidad();
            $unidad->plan_actividad_id =  intval($plan->id);
            $unidad->unidad =  $unit;
            $unidad->save();
        }

        $request->session()->flash('status','Actividad actualizada correctamente');
        return redirect()->route('planes.edit',['plane'=> $plan,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }











    public function confirmDelete($id)
    {
        $plan = Plan_actividad::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
    
        return view('plan.confirmDelete',['plan'=> $plan, 'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function destroy(Request $request,$id)
    {
        $datos = explode(";", trim($_POST['url']));

        $plan = Plan_actividad::findOrFail($id);
        
        try {
            $plan->delete();
            $request->session()->flash('status','Actividad con id '.$id.' eliminada correctamente');
        }catch (\Illuminate\Database\QueryException $e) {
            $request->session()->flash('status','Actividad con id '.$id.' no se puede eliminar dado que varias tareas dependen de él');
        }

        return redirect()->route('planes.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);    
    }

    public function show($id)
    {
        $plan = Plan_actividad::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('plan.show',['plan'=> $plan,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }
}