<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seguimiento;
use App\Estado_seguimiento;
use App\Actividad;
use App\Tema;
use App\User;
use App\Actividad_archivo;
use App\Http\Requests\StoreActividades;
use Illuminate\Support\Facades\Auth;
use PDF;

class ActividadController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware(['permission:actividades.index|actividades_assign_them.index'])->only('index');
        $this->middleware('can:actividades.create')->only('create','store');
        $this->middleware(['permission:actividades.edit|actividades_assign_them.edit'])->only('edit','update');
        $this->middleware('can:actividades.show')->only('show');
        $this->middleware(['permission:actividades.destroy|actividades_assign_them.destroy'])->only('confirmDelete','destroy');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }
    
    public function generate()
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.index');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::all();
        }
        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('temas.*','tema_user.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->get();
        }
        
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        return view('actividad.informe',['temas'=> $temas, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
    }

    public function search_item($item){
        $actividades = Actividad::where('seguimiento_id', '=', $item)->get();
        return json_encode($actividades);
    }
    
    public function print_data($id,$fecha1,$fecha2,$select_search){
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.index');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            if($select_search == 1){
                $actividades = Actividad::join('seguimientos','actividades.seguimiento_id', '=', 'seguimientos.id')
                                                ->select('actividades.*')
                                                ->where('actividades.id', '=', $id)
                                                ->whereBetween('actividades.fecha', [$fecha1, $fecha2])
                                                ->orderBy('seguimientos.tema_id', 'ASC')
                                                ->orderBy('actividades.seguimiento_id','asc')->get();
            }else{
                $actividades = Actividad::join('seguimientos','actividades.seguimiento_id', '=', 'seguimientos.id')
                                                ->select('actividades.*')
                                                ->whereBetween('actividades.fecha', [$fecha1, $fecha2])
                                                ->orderBy('seguimientos.tema_id', 'ASC')
                                                ->orderBy('actividades.seguimiento_id','asc')->get();
            }
        }
        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            if($select_search == 1){
                $actividades = Actividad::join('seguimientos','actividades.seguimiento_id', '=', 'seguimientos.id')
                                                ->join('tema_user','tema_user.tema_id', '=', 'seguimientos.tema_id')

                                                ->select('actividades.*','tema_user.*')
                                                ->where('tema_user.user_id', '=', $this->id_user)
                                                ->where('actividades.id', '=', $id)
                                                ->whereBetween('actividades.fecha', [$fecha1, $fecha2])
                                                ->orderBy('seguimientos.tema_id', 'ASC')
                                                ->orderBy('actividades.seguimiento_id','asc')->get();
            }else{
                $actividades = Actividad::join('seguimientos','actividades.seguimiento_id', '=', 'seguimientos.id')
                                                ->join('tema_user','tema_user.tema_id', '=', 'seguimientos.tema_id')
                                                ->select('actividades.*','tema_user.*')
                                                ->where('tema_user.user_id', '=', $this->id_user)
                                                ->whereBetween('actividades.fecha', [$fecha1, $fecha2])
                                                ->orderBy('seguimientos.tema_id', 'ASC')
                                                ->orderBy('actividades.seguimiento_id','asc')->get();
            }
        }
        $pdf = PDF::loadView('actividad.actividadprint',['actividades'=>$actividades,'id'=>$id,'fecha1'=>$fecha1,'fecha2'=>$fecha2,'select_search'=>$select_search]);
        return $pdf->stream('actividad'.$id.'.pdf');

        //return view('tema.temaprint', ['actividades'=> $actividades]);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        $data_search2 = trim($request->get('data_search2'));
        
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('actividades.index');
        $permiso3 = Auth::user()->hasPermissionTo('actividades_assign_them.index');
        $enter_if = 0;
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $actividad = Actividad::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 3){
                        $actividad = Actividad::where('seguimiento_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 4){  //Fecha Rango creación 
                            $actividad = Actividad::whereBetween('created_at', [$data_search.' 00:00:00', $data_search2.' 23:59:59'])->orderBy('id','desc')->paginate(20)->withQueryString();
                        }else{
                            $actividad = Actividad::where('fecha', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                        }
                    }
                }
            }else{
                $select_search = '1';
                $actividad = Actividad::orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }
        
        if($permiso3 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                        ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('actividades.*')
                                        ->where('actividades.id', 'like', '%'.$data_search.'%')
                                        ->where('tema_user.user_id', '=', $this->id_user)
                                        ->orderBy('actividades.id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 3){
                        $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                                ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                ->select('actividades.*')
                                                ->where('actividades.seguimiento_id', '=', $data_search)
                                                ->where('tema_user.user_id', '=', $this->id_user)
                                                ->orderBy('actividades.id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 4){  //Fecha Rango creación 
                            $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                                    ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                    ->select('actividades.*')
                                                    ->whereBetween('actividades.created_at', [$data_search.' 00:00:00', $data_search2.' 23:59:59'])
                                                    ->where('tema_user.user_id', '=', $this->id_user)
                                                    ->orderBy('actividades.id','desc')->paginate(20)->withQueryString();
                        }else{
                            $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                                    ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                    ->select('actividades.*')
                                                    ->where('actividades.fecha', '=', $data_search)
                                                    ->where('tema_user.user_id', '=', $this->id_user)
                                                    ->orderBy('actividades.id','desc')->paginate(20)->withQueryString();
                        }
                    }
                }
            }else{
                $select_search = '1';
                $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                        ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('actividades.*')
                                        ->where('tema_user.user_id', '=', $this->id_user)
                                        ->orderBy('actividades.id','desc')->paginate(20)->withQueryString();
            }
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('actividad.index', ['actividades'=> $actividad,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
    }

    public function create()
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.index');
        $permiso2 = Auth::user()->hasPermissionTo('seguimientos_assign_them.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $seguimientos = Seguimiento::all();
        }
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $seguimientos = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('seguimientos.*')
                                        ->where('tema_user.user_id', '=', $this->id_user)->get();
        }
        
        $estados = Estado_seguimiento::all();

        $seguimiento = (isset($_GET['seguimiento'])?$_GET['seguimiento']:0);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        if($seguimiento == 0){
            return view('actividad.create',['estados'=> $estados,'seguimientos'=> $seguimientos, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view('actividad.createActSeg',['estados'=> $estados,'seguimientos'=> $seguimientos, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page, 'seguimiento'=>$seguimiento]);
        }
    }

    public function store(StoreActividades $request)
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));

        $actividad = new Actividad();
        $actividad->actividad = $validated['actividad'];
        $actividad->estado_id = $validated['estado_id'];
        $actividad->fecha = $validated['fecha'];
        $actividad->acciones_adelantadas = $validated['acciones_adelantadas'];
        $actividad->acciones_pendientes = $validated['acciones_pendientes'];
        $actividad->dificultades = $validated['dificultades'];
        $actividad->alternativas = $validated['alternativas'];
        $actividad->resultados = $validated['resultados'];
        $actividad->seguimiento_id = $validated['seguimiento_id'];
        $actividad->save();

        if($request->file('evidencia') != null){
            foreach ($validated['evidencia'] as $key => $file){
                $path = public_path() . '/evidencia';
                $fileName = uniqid() . $file->getClientOriginalName();
                $file->move($path, $fileName);

                $evidencia = new Actividad_archivo();
                $evidencia->actividad_id =  intval($actividad->id);
                $evidencia->evidencia =  $fileName;
                $evidencia->save();
            }
        }

        $request->session()->flash('status','Tarea creada correctamente');
        
        if(isset($datos[4])){
            return redirect()->route('seguimientos.index', ['select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }else{
            return redirect()->route('actividades.index', ['actividades'=> $actividad,'select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }
    }

    public function edit($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.index');
        $permiso2 = Auth::user()->hasPermissionTo('seguimientos_assign_them.index');
        $enter_if = 0;
        
        $estados = Estado_seguimiento::all();
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $seguimientos = Seguimiento::all();
        }
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $seguimientos = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('seguimientos.*')
                                        ->where('tema_user.user_id', '=', $this->id_user)->get();
        }

        $permiso1 = Auth::user()->hasPermissionTo('actividades.edit');
        $permiso2 = Auth::user()->hasPermissionTo('actividades_assign_them.edit');
        $enter_if = 0;
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::findOrFail($id);
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                    ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                    ->select('actividades.*')
                                    ->where('tema_user.user_id', '=', $this->id_user)->get();
            $actividad = $actividad[0];
        }

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        return view('actividad.edit',['actividad'=> $actividad, 'estados'=> $estados,'seguimientos'=> $seguimientos,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
    }

    public function update(StoreActividades $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();
        
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('actividades.edit');
        $permiso2 = Auth::user()->hasPermissionTo('actividades_assign_them.edit');
        $enter_if = 0;
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::findOrFail($id);
            $actividad->actividad = $validated['actividad'];
            $actividad->estado_id = $validated['estado_id'];
            $actividad->fecha = $validated['fecha'];
            $actividad->acciones_adelantadas = $validated['acciones_adelantadas'];
            $actividad->acciones_pendientes = $validated['acciones_pendientes'];
            $actividad->dificultades = $validated['dificultades'];
            $actividad->alternativas = $validated['alternativas'];
            $actividad->resultados = $validated['resultados'];
            $actividad->seguimiento_id = $validated['seguimiento_id'];
            $actividad->save();
    
            Actividad_archivo::where('actividad_id','=',$id)->delete();
    
            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $tema_evidencia = new Actividad_archivo();
                    $tema_evidencia->actividad_id =  intval($id);
                    $tema_evidencia->evidencia =  $input_evidence;
                    $tema_evidencia->save();
                }
            }
    
            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);
    
                    $tema_evidencia = new Actividad_archivo();
                    $tema_evidencia->actividad_id =  intval($id);
                    $tema_evidencia->evidencia =  $fileName;
                    $tema_evidencia->save();   
                }
            }
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                    ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                    ->select('actividades.*')
                                    ->where('tema_user.user_id', '=', $this->id_user)->get();
            $actividad = $actividad[0];

            $actividad->actividad = $validated['actividad'];
            $actividad->estado_id = $validated['estado_id'];
            $actividad->fecha = $validated['fecha'];
            $actividad->acciones_adelantadas = $validated['acciones_adelantadas'];
            $actividad->acciones_pendientes = $validated['acciones_pendientes'];
            $actividad->dificultades = $validated['dificultades'];
            $actividad->alternativas = $validated['alternativas'];
            $actividad->resultados = $validated['resultados'];
            $actividad->seguimiento_id = $validated['seguimiento_id'];
            $actividad->save();

            Actividad_archivo::where('actividad_id','=',$id)->delete();

            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $tema_evidencia = new Actividad_archivo();
                    $tema_evidencia->actividad_id =  intval($id);
                    $tema_evidencia->evidencia =  $input_evidence;
                    $tema_evidencia->save();
                }
            }

            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);

                    $tema_evidencia = new Actividad_archivo();
                    $tema_evidencia->actividad_id =  intval($id);
                    $tema_evidencia->evidencia =  $fileName;
                    $tema_evidencia->save();   
                }
            }
        }

        $request->session()->flash('status','Tarea actualizada correctamente');

        return redirect()->route('actividades.edit',['actividade'=> $actividad,'select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
    }

    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        return view('actividad.show',['actividad'=> $actividad,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
    }

    public function confirmDelete($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('actividades.destroy');
        $permiso2 = Auth::user()->hasPermissionTo('actividades_assign_them.destroy');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::findOrFail($id);
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                    ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                    ->select('actividades.*')
                                    ->where('tema_user.user_id', '=', $this->id_user)->get();
            $actividad = $actividad[0];
        }

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];
        
        return view('actividad.confirmDelete',['actividad'=> $actividad, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);   
    }

    public function destroy(Request $request,$id)
    {
        $datos = explode(";", trim($_POST['url']));
        
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('actividades.destroy');
        $permiso2 = Auth::user()->hasPermissionTo('actividades_assign_them.destroy');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::findOrFail($id);
        }
        
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $actividad = Actividad::join('seguimientos','seguimientos.id', '=', 'actividades.seguimiento_id')
                                    ->join('temas','temas.id', '=', 'seguimientos.tema_id')
                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                    ->select('actividades.*')
                                    ->where('tema_user.user_id', '=', $this->id_user)->get();
            $actividad = $actividad[0];
        }
            
        $actividad->delete();

        $request->session()->flash('status','Tarea con id '.$id.' eliminada correctamente');

        return redirect()->route('actividades.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
    }
}
