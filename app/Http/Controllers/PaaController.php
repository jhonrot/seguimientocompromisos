<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paa;
use App\Modalidad;
use App\Presupuesto;
use App\Proyecto;
use App\Http\Requests\StorePaas;
use Illuminate\Support\Facades\DB;

class PaaController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:paas.index')->only('index');
        $this->middleware('can:paas.create')->only('create','store');
        $this->middleware('can:paas.edit')->only('edit','update');
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
                $paas = Paa::where('socializacion', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                if($select_search == 2){
                    $paas = Paa::where('publicacion', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $paas = Paa::join('presupuestos','presupuestos.id', '=', 'paas.presupuesto_id')
                                ->select('paas.*')->where('presupuestos.proyecto_id', '=', $data_search)
                                ->orderBy('paas.id','desc')->paginate(20)->withQueryString();
                }
            }
        }else{
            $select_search = '3';
            $data_search = $proj;
            $paas = Paa::join('presupuestos','presupuestos.id', '=', 'paas.presupuesto_id')
                            ->select('paas.*')->where('presupuestos.proyecto_id', '=', $proj)
                            ->orderBy('paas.id','desc')->paginate(20)->withQueryString();
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('paa.index', ['paas'=> $paas,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2,'place2'=> $place2,'proj'=> $proj]);
    }

    public function create()
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');

        $modalidades = Modalidad::all();
        $proyectos = Proyecto::all();
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        $proj = $_GET['proj'];
        $bp = $_GET['bp'];
        $place = $_GET['place'];

        return view('paa.create',['modalidades'=>$modalidades,'proyectos'=>$proyectos,'bp'=>$bp,'proj'=>$proj,'place'=>$place,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2]);
    }

    public function store(StorePaas $request) 
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $pre = new Presupuesto();
        $pre->presupuesto_proyecto = $validated['presupuesto_proyecto'];
        $pre->cantidad = $validated['cantidad'];
        $pre->proyecto_id = $validated['proyecto_id'];
        $pre->save();

        foreach ($validated['modalidad_id'] as $key => $array_Mod){
            $mod_pres_id_array[$array_Mod] = ['presupuesto_modalidad'=>$validated['presupuesto_modalidad'][$key]];
        }

        $pre->modalidades()->syncWithoutDetaching($mod_pres_id_array);

        $paa = new Paa();
        $paa->socializacion = $validated['socializacion'];
        $paa->plazo = $validated['plazo'];
        $paa->publicacion = $validated['publicacion'];
        $paa->id_paa = $validated['id_paa'];
        $paa->presupuesto_id = $pre->id;
        $paa->save();

        $request->session()->flash('status','PAA creado correctamente');
        //return redirect()->route('paas.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'proj'=>$datos[3],'bp'=>$datos[4],'place'=>$datos[5],'select_search2'=>$datos[6],'data_search2'=>$datos[7],'page2'=> $datos[8]]);
        return redirect()->route('proyectos.index', ['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $select_search2 = (isset($_GET['select_search2'])?$_GET['select_search2']:'');
        $data_search2 = (isset($_GET['data_search2'])?$_GET['data_search2']:'');
        $page2  = (isset($_GET['page2'])?$_GET['page2']:'');

        $modalidades = Modalidad::all();

        $paa = Paa::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        $pres = $_GET['pres'];

        $proj = $_GET['proj'];
        $bp = $_GET['bp'];
        $place = $_GET['place'];

        $proj_real = $_GET['proj_real'];

        return view('paa.edit',['paa'=> $paa,'modalidades'=>$modalidades,'bp'=>$bp,'proj'=>$proj,'place'=>$place,'pres'=>$pres,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page,'select_search2'=>$select_search2,'data_search2'=>$data_search2,'page2'=> $page2,'proj_real'=>$proj_real]);
    }

    public function update(StorePaas $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $pre = Presupuesto::findOrFail($datos[3]);
        $pre->presupuesto_proyecto = $validated['presupuesto_proyecto'];
        $pre->cantidad = $validated['cantidad'];
        $pre->save();

        DB::table('modalidad_presupuesto')->where('presupuesto_id',$datos[3])->delete();

        foreach ($validated['modalidad_id'] as $key => $array_Mod){
            $mod_pres_id_array[$array_Mod] = ['presupuesto_modalidad'=>$validated['presupuesto_modalidad'][$key]];
        }

        $pre->modalidades()->syncWithoutDetaching($mod_pres_id_array);

        $paa = Paa::findOrFail($id);
        $paa->socializacion = $validated['socializacion'];
        $paa->plazo = $validated['plazo'];
        $paa->publicacion = $validated['publicacion'];
        $paa->id_paa = $validated['id_paa'];
        $paa->save();

        $request->session()->flash('status','PAA actualizado correctamente');

        return redirect()->route('paas.edit',['paa'=> $id,
        'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],
        'pres'=> $datos[3],'proj'=>$datos[4],'bp'=>$datos[5],'place'=>$datos[6],
        'select_search2'=>$datos[7],'data_search2'=>$datos[8],'page2'=> $datos[9],
        'proj_real'=> $datos[10] ]);
    }
}
