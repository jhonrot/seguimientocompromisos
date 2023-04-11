<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ejecucion;
use App\Precontractual;
use App\Http\Requests\StoreEjecuciones;

class EjecucionController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:ejecucions.index')->only('index');
        $this->middleware('can:ejecucions.create')->only('create','store');
        $this->middleware('can:ejecucions.edit')->only('edit','update');
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
                $ejecs = Ejecucion::where('fecha_suscripcion_contrato', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                if($select_search == 2){
                    $ejecs = Ejecucion::where('fecha_cierre_proyecto', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $ejecs = Ejecucion::join('precontractuales','precontractuales.id', '=', 'ejecuciones.precontractual_id')
                                        ->join('cdps','precontractuales.cdp_id', '=', 'cdps.id')
                                        ->select('ejecuciones.*')->where('cdps.proyecto_id', '=', $proj)
                                        ->orderBy('ejecuciones.id','desc')->paginate(20)->withQueryString();
                }
            }
        }else{
            $select_search = '3';
            $data_search = $proj;
            $ejecs = Ejecucion::join('precontractuales','precontractuales.id', '=', 'ejecuciones.precontractual_id')
                            ->join('cdps','precontractuales.cdp_id', '=', 'cdps.id')
                            ->select('ejecuciones.*')->where('cdps.proyecto_id', '=', $proj)
                            ->orderBy('ejecuciones.id','desc')->paginate(20)->withQueryString();
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);

        return view('ejecucion.index', ['ejecs'=> $ejecs,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2,'place2'=> $place2,'proj'=> $proj]);
    }

    public function create()
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        $proj = $_GET['proj'];
        $bp = $_GET['bp'];
        $place = $_GET['place'];
        $pre = $_GET['pre'];

        return view('ejecucion.create',['bp'=>$bp,'proj'=>$proj,'place'=>$place,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2,'pre'=>$pre]);
    }

    public function store(StoreEjecuciones $request) 
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $ejec = new Ejecucion();
        $ejec->fecha_suscripcion_contrato = $validated['fecha_suscripcion_contrato'];
        $ejec->fecha_socializacion_contratista = $validated['fecha_socializacion_contratista'];
        $ejec->tiempo_ejecucion = $validated['tiempo_ejecucion'];
        $ejec->fecha_cierre_proyecto = $validated['fecha_cierre_proyecto'];
        $ejec->tiempo_etapa_contractual = $validated['tiempo_etapa_contractual'];
        $ejec->precontractual_id = $validated['precontractual_id'];

        $ejec->prorroga = ($request->get('prorroga')==null?0:$validated['prorroga']);
        $ejec->tiempo_prorroga = $validated['tiempo_prorroga'];
        $ejec->fecha_prorroga = $validated['fecha_prorroga'];

        $ejec->save();

        $request->session()->flash('status','Etapa ejecución creada correctamente');

        return redirect()->route('proyectos.index', ['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');

        $ejec = Ejecucion::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        $proj = $_GET['proj'];
        $bp = $_GET['bp'];
        $place = $_GET['place'];

        return view('ejecucion.edit',['ejec'=> $ejec,'bp'=>$bp,'proj'=>$proj,'place'=>$place,
        'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,
        'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2]);
    }

    public function update(StoreEjecuciones $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $ejec = Ejecucion::findOrFail($id);
        $ejec->fecha_suscripcion_contrato = $validated['fecha_suscripcion_contrato'];
        $ejec->fecha_socializacion_contratista = $validated['fecha_socializacion_contratista'];
        $ejec->tiempo_ejecucion = $validated['tiempo_ejecucion'];
        $ejec->fecha_cierre_proyecto = $validated['fecha_cierre_proyecto'];
        $ejec->tiempo_etapa_contractual = $validated['tiempo_etapa_contractual'];

        $ejec->prorroga = ($request->get('prorroga')==null?0:$validated['prorroga']);
        $ejec->tiempo_prorroga = $validated['tiempo_prorroga'];
        $ejec->fecha_prorroga = $validated['fecha_prorroga'];

        $ejec->save();
        $request->session()->flash('status','Etapa ejecución actualizada correctamente');
        
        return redirect()->route('ejecuciones.edit',['ejecucione'=> $id,
        'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],
        'proj'=>$datos[3],'bp'=>$datos[4],'place'=>$datos[5],
        'select_search2'=>$datos[6],'data_search2'=>$datos[7],'page2'=> $datos[8]]);
    }
}
