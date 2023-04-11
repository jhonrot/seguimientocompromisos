<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tema;
use App\Actividad;
use App\User;
use App\Tema_archivo;
use App\Estado_seguimiento;
use App\Indice;
use App\Equipo_trabajo;
use App\Sub_clasificacion;
use App\Http\Requests\StoreTemas;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompromisoActualizado;
use App\Mail\TemaPrioridadAlta;
use App\Mail\CompromisoAlerta;
use Illuminate\Support\Facades\Auth;
use PDF;

class TemaController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware(['permission:temas.index|temas_assign.index'])->only('index');
        //$this->middleware('can:temas.create')->only('create','store');
        $this->middleware(['permission:temas.edit|temas_assign.edit'])->only('edit','update');
        $this->middleware('can:temas.show')->only('show');
        $this->middleware('permission:temas.destroy|temas_assign.destroy')->only('confirmDelete','destroy');
        $this->middleware('can:temas.print')->only('printForm','prinTema');
        $this->middleware('can:temas.inform')->only('data_inform');
    }
    
    public function notification_vencimiento_tema(){
        $hoy = date('Y-m-d');
        $day_next = date("Y-m-d",strtotime($hoy."+ 5 days"));
        $temas = Tema::whereBetween('fecha_cumplimiento', [$hoy, $day_next])->get();
        $cant_notif = 0;
        foreach($temas as  $tema){
            $cant_notif++;
            Mail::to($tema->asignador)->send(new CompromisoAlerta($tema));
            Mail::to($tema->users)->send(new CompromisoAlerta($tema));
            Mail::to('gabravo.2016@gmail.com')->send(new CompromisoAlerta($tema));
        }
        return $cant_notif;
    }

    public function search(){
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.index');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::all();
            return json_encode($temas);
        }
        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('temas.*','tema_user.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->get();
            return json_encode($temas);
        }
    }
    
    public function print_reporte($item){  //Vencidos
        $date = date('Y-m-d');
        $temas = Tema::where('estado_id', '=', 1)->where('fecha_cumplimiento', '<', $date)->get();

        $pdf = PDF::loadView('tema.tema_reporte',['temas'=>$temas,'item'=>$item]);
        return $pdf->stream('tema'.date('d_m_y').'.pdf');
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
        $data_search2 = trim($request->get('data_search2'));

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.index');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.index');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $tema = Tema::where('tema', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 4){   //Indice
                        $tema = Tema::join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')->select('temas.*')
                        ->where('clasificaciones.indice_id', '=', $data_search)->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 5){  //Clasificación
                            $tema = Tema::where('clasificacion_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                        }else{
                            if($select_search == 6){  //Subclasificación
                                $tema = Tema::where('subclasificacion_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                            }else{
                                if($select_search == 7){  //Fecha Rango creación 
                                    $tema = Tema::whereBetween('created_at', [$data_search.' 00:00:00', $data_search2.' 23:59:59'])->orderBy('id','desc')->paginate(20)->withQueryString();
                                }else{
                                    if($select_search == 8){  //Organismo 
                                        $tema = Tema::join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                        ->join('indices','clasificaciones.indice_id', '=', 'indices.id')
                                        ->join('equipo_trabajos','indices.equipo_id', '=', 'equipo_trabajos.id')
                                        ->select('temas.*')
                                        ->where('equipo_trabajos.organismo_id', '=', $data_search)
                                        ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                                    }else{
                                        if($select_search == 9){  //Equipo 
                                            $tema = Tema::join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                            ->join('indices','clasificaciones.indice_id', '=', 'indices.id')
                                            ->select('temas.*')
                                            ->where('indices.equipo_id', '=', $data_search)
                                            ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                                        }else{
                                            $tema = Tema::where('estado_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                $select_search = '1';
                $tema = Tema::orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }

        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                ->select('temas.*')
                                ->where('temas.tema', 'like', '%'.$data_search.'%')
                                ->where('tema_user.user_id', '=', $this->id_user)
                                ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 4){   //Indice
                        $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                        ->join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                        ->select('temas.*')
                        ->where('clasificaciones.indice_id', '=', $data_search)
                        ->where('tema_user.user_id', '=', $this->id_user)
                        ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 5){  //Clasificación
                            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('temas.*')
                            ->where('temas.clasificacion_id', '=', $data_search)
                            ->where('tema_user.user_id', '=', $this->id_user)
                            ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                        }else{
                            if($select_search == 6){  //Subclasificación
                                $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                            ->select('temas.*')
                                            ->where('temas.subclasificacion_id', '=', $data_search)
                                            ->where('tema_user.user_id', '=', $this->id_user)
                                            ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                            }else{
                                if($select_search == 7){  //Fecha Rango creación
                                    $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                            ->select('temas.*')
                                            ->whereBetween('temas.created_at', [$data_search.' 00:00:00', $data_search2.' 23:59:59'])
                                            ->where('tema_user.user_id', '=', $this->id_user)
                                            ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                                }else{
                                    if($select_search == 8){  //Organismo 
                                        $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                        ->join('indices','clasificaciones.indice_id', '=', 'indices.id')
                                        ->join('equipo_trabajos','indices.equipo_id', '=', 'equipo_trabajos.id')
                                        ->select('temas.*')
                                        ->where('equipo_trabajos.organismo_id', '=', $data_search)
                                        ->where('tema_user.user_id', '=', $this->id_user)
                                        ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                                    }else{
                                        if($select_search == 9){  //Equipo 
                                            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                            ->join('clasificaciones','temas.clasificacion_id', '=', 'clasificaciones.id')
                                            ->join('indices','clasificaciones.indice_id', '=', 'indices.id')
                                            ->select('temas.*')
                                            ->where('indices.equipo_id', '=', $data_search)
                                            ->where('tema_user.user_id', '=', $this->id_user)
                                            ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                                        }else{
                                    
                                    
                                    
                                            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                        ->select('temas.*')
                                                        ->where('temas.estado_id', '=', $data_search)
                                                        ->where('tema_user.user_id', '=', $this->id_user)
                                                        ->orderBy('temas.id','desc')->paginate(20)->withQueryString();
                                        }
                                    }
                                }
                            }
                        }
                    }     
                }
            }else{
                $select_search = '1';
                $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('temas.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->orderBy('temas.id','desc')->paginate(20)->withQueryString();
            }
        }
        
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('tema.index', ['temas'=> $tema,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
    }

    public function edit($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.edit');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.edit');
        $enter_if = 0;

        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')->where('state_logic', '=', '1')->orderBy('name','asc')->get();
        $estados = Estado_seguimiento::all();
        //$indice = Indice::all();
        
        $organismo_user_auth = Auth::user()->organismo_id;
        $equipos = Equipo_trabajo::where('organismo_id', '=', $organismo_user_auth)->get();
        $sub_clasificaciones = Sub_clasificacion::all();

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::findOrFail($id);
        }
        
        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                        ->select('temas.*')
                        ->where('temas.id', '=', $id)
                        ->where('tema_user.user_id', '=', $this->id_user)->get();
            $tema = $tema[0];
        }

        if($enter_if == 1 && isset($tema->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $data_search2 = $_GET['data_search2'];
            $this->page  = $_GET['page'];

            return view('tema.edit',['tema'=> $tema,'estados'=> $estados,'responsables'=> $responsables,'equipos'=>$equipos,'sub_clasificaciones'=>$sub_clasificaciones,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        } 
    }

    public function update(StoreTemas $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.edit');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.edit');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;

            $validated = $request->validated();

            $tema = Tema::findOrFail($id);
            $tema->estado_id = $validated['estado_id'];
            if($request->get('estado_id')==3){
                $tema->fecha_alerta_cumplimiento = date('Y-m-d');
            }
            $tema->save();

            Tema_archivo::where('tema_id','=',$id)->delete();

            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $tema_evidencia = new Tema_archivo();
                    $tema_evidencia->tema_id =  intval($id);
                    $tema_evidencia->evidencia =  $input_evidence;
                    $tema_evidencia->save();
                }
            }

            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);

                    $tema_evidencia = new Tema_archivo();
                    $tema_evidencia->tema_id =  intval($id);
                    $tema_evidencia->evidencia =  $fileName;
                    $tema_evidencia->save();   
                }
            }
            
            $estado_initial = $request->get('estado_id_initial');            

            Mail::to($tema->asignador)->send(new CompromisoActualizado($tema, $estado_initial));
            Mail::to($tema->users)->send(new CompromisoActualizado($tema, $estado_initial));

            $request->session()->flash('status','Compromiso actualizado correctamente');
        }

        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                        ->select('temas.*')
                        ->where('temas.id', '=', $id)
                        ->where('tema_user.user_id', '=', $this->id_user)->get();

            $tema = $tema[0];

            $validated = $request->validated();

            $tema->tema = $validated['tema'];
            $tema->estado_id = $validated['estado_id'];
            if($request->get('estado_id')==3){
                $tema->fecha_alerta_cumplimiento = date('Y-m-d');
            }
            $tema->save();

            Tema_archivo::where('tema_id','=',$id)->delete();

            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $tema_evidencia = new Tema_archivo();
                    $tema_evidencia->tema_id =  intval($id);
                    $tema_evidencia->evidencia =  $input_evidence;
                    $tema_evidencia->save();
                }
            }

            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);

                    $tema_evidencia = new Tema_archivo();
                    $tema_evidencia->tema_id =  intval($id);
                    $tema_evidencia->evidencia =  $fileName;
                    $tema_evidencia->save();   
                }
            }
            
            $estado_initial = $request->get('estado_id_initial');            

            Mail::to($tema->asignador)->send(new CompromisoActualizado($tema, $estado_initial));
            Mail::to($tema->users)->send(new CompromisoActualizado($tema, $estado_initial));

            $request->session()->flash('status','Compromiso actualizado correctamente');
        }

        if($enter_if == 1 && isset($tema->id)){
            return redirect()->route('temas.edit',['tema'=> $tema,'select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }else{
            return view("error.Error403");
        }
    }

    public function show($id)
    {
        $tema = Tema::findOrFail($id);

        $seg = (isset($_GET['seg'])?$_GET['seg']:0);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        if($seg == 0){
            return view('tema.show',['tema'=> $tema,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view('tema.showTemaSeg',['tema'=> $tema,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page, 'seg'=>$seg]);
        }
    }

    public function confirmDelete($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.destroy');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.destroy');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::findOrFail($id);
        }

        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                        ->select('temas.*','tema_user.*')
                        ->where('temas.id', '=', $id)
                        ->where('tema_user.user_id', '=', $this->id_user)->get();
            $tema = $tema[0];
        }

        if($enter_if == 1 && isset($tema->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $data_search2 = $_GET['data_search2'];
            $this->page  = $_GET['page'];
        
            return view('tema.confirmDelete',['tema'=> $tema, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function destroy(Request $request,$id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.destroy');
        $permiso4 = Auth::user()->hasPermissionTo('temas_assign.destroy');
        $enter_if = 0;

        $datos = explode(";", trim($_POST['url']));

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::findOrFail($id);
        }
        
        if($permiso4 && $enter_if == 0){
            $enter_if = 1;
            $tema = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                        ->select('temas.*','tema_user.*')
                        ->where('temas.id', '=', $id)
                        ->where('tema_user.user_id', '=', $this->id_user)->get();
            $tema = $tema[0];
        }

        if($enter_if == 1 && isset($tema->id)){
            try {
                $tema->delete();
                $request->session()->flash('status','Compromiso con id '.$id.' eliminado correctamente');
            }catch (\Illuminate\Database\QueryException $e) {
                $request->session()->flash('status','Compromiso con id '.$id.' no se puede eliminar dado que varias actividades dependen de él');
            }

            return redirect()->route('temas.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }else{
            return view("error.Error403");
        }
    }
}
