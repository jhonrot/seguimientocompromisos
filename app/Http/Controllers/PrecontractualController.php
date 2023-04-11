<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Precontractual;
use App\Cdp;
use App\Proyecto;
use App\Http\Requests\StorePrecontractuales;

class PrecontractualController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:contractuals.index')->only('index');
        $this->middleware('can:contractuals.create')->only('create','store');
        $this->middleware('can:contractuals.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function index(Request $request)
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');
        $place2  = (isset($_GET['place2'])?$_GET['place2']:'');

        $proj  = (isset($_GET['proj'])?$_GET['proj']:'');

        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $conts = Precontractual::where('fecha_convocatoria', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                if($select_search == 2){
                    $conts = Precontractual::where('fecha_adjudicacion', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $conts = Precontractual::join('cdps','precontractuales.cdp_id', '=', 'cdps.id')
                                ->select('precontractuales.*')->where('cdps.proyecto_id', '=', $data_search)
                                ->orderBy('precontractuales.id','desc')->paginate(20)->withQueryString();
                }
            }
        }else{

            $select_search = '3';
            $data_search = $proj;
            $conts = Precontractual::join('cdps','precontractuales.cdp_id', '=', 'cdps.id')
                                ->select('precontractuales.*')->where('cdps.proyecto_id', '=', $data_search)
                                ->orderBy('precontractuales.id','desc')->paginate(20)->withQueryString();
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('precontractual.index', ['conts'=> $conts,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2,'place2'=> $place2,'proj'=> $proj]);
    }

    public function create()
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');

        $proyectos = Proyecto::all();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        $proj = $_GET['proj'];
        $bp = $_GET['bp'];
        $place = $_GET['place'];

        return view('precontractual.create',['proyectos'=>$proyectos,'bp'=>$bp,'proj'=>$proj,'place'=>$place,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2]);
    }

    public function store(StorePrecontractuales $request) 
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $cdp = new Cdp();
        $cdp->cdp_asignado = $validated['cdp_numero'];
        $cdp->cdp_numero = $validated['cdp_numero'];
        $cdp->fecha_expedicion = $validated['fecha_expedicion'];
        $cdp->proyecto_id = $validated['proyecto_id'];
        $cdp->save();

        $cont = new Precontractual();
        $cont->paac = $validated['paac'];
        $cont->cdp_id = $cdp->id;
        $cont->fecha_convocatoria = $validated['fecha_convocatoria'];
        $cont->fecha_aprobacion_asp = $validated['fecha_aprobacion_asp'];
        $cont->fecha_aprobacion_edp = $validated['fecha_aprobacion_edp'];
        $cont->fecha_publicacion_contratacion = $validated['fecha_publicacion_contratacion'];
        $cont->plazo_adjudicacion = $validated['plazo_adjudicacion'];
        $cont->fecha_adjudicacion = $validated['fecha_adjudicacion'];
        $cont->save();

        $request->session()->flash('status','Etapa precontractual creada correctamente');
        //return redirect()->route('precontractuales.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'proj'=>$datos[3],'bp'=>$datos[4],'place'=>$datos[5],'select_search2'=>$datos[6],'data_search2'=>$datos[7],'page2'=> $datos[8]]);
        return redirect()->route('proyectos.index', ['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]); 
    }

    public function edit($id)
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');

        $cont = Precontractual::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        $cdps = $_GET['cdps'];

        $proj = $_GET['proj'];
        $bp = $_GET['bp'];
        $place = $_GET['place'];

        $proj_real = $_GET['proj_real'];

        return view('precontractual.edit',['cont'=> $cont,'bp'=>$bp,'proj'=>$proj,'place'=>$place,'cdps'=>$cdps,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2,'proj_real'=>$proj_real]);
    }

    public function update(StorePrecontractuales $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $cdp = Cdp::findOrFail($datos[3]);
        $cdp->cdp_asignado = $validated['cdp_numero'];
        $cdp->cdp_numero = $validated['cdp_numero'];
        $cdp->fecha_expedicion = $validated['fecha_expedicion'];
        $cdp->save();

        $cont = Precontractual::findOrFail($id);
        $cont->paac = $validated['paac'];
        $cont->fecha_convocatoria = $validated['fecha_convocatoria'];
        $cont->fecha_aprobacion_asp = $validated['fecha_aprobacion_asp'];
        $cont->fecha_aprobacion_edp = $validated['fecha_aprobacion_edp'];
        $cont->fecha_publicacion_contratacion = $validated['fecha_publicacion_contratacion'];
        $cont->plazo_adjudicacion = $validated['plazo_adjudicacion'];
        $cont->fecha_adjudicacion = $validated['fecha_adjudicacion'];
        $cont->save();

        $request->session()->flash('status','Etapa precontractual actualizada correctamente');

        return redirect()->route('precontractuales.edit',['precontractuale'=> $id,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'cdps'=> $datos[3],'proj'=>$datos[4],'bp'=>$datos[5],'place'=>$datos[6],'select_search2'=>$datos[7],'data_search2'=>$datos[8],'page2'=> $datos[9],'proj_real'=> $datos[10]]);
    }
}
