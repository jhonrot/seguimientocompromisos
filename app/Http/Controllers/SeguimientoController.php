<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seguimiento;
use App\Estado_seguimiento;
use App\Tema;
use App\Seguimiento_archivo;
use App\Http\Requests\StoreSeguimientos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SeguimientoTemaCompletado;
use App\User;
use App\Mail\DificultadesSeguimiento;

class SeguimientoController extends Controller
{
    public $page;
    protected $id_user;

    public function __construct(){
        $this->middleware(['permission:seguimientos.index|seguimientos_assign_them.index'])->only('index');
        $this->middleware('can:seguimientos.create')->only('create','store');
        $this->middleware(['permission:seguimientos.edit|seguimientos_assign_them.edit'])->only('edit','update');
        $this->middleware('can:seguimientos.show')->only('show');
        $this->middleware(['permission:seguimientos.destroy|seguimientos_assign_them.destroy'])->only('confirmDelete','destroy');
    }

    public function search(){
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.index');
        $permiso3 = Auth::user()->hasPermissionTo('seguimientos_assign_them.index');

        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $seguimientos = Seguimiento::all();
            return json_encode($seguimientos);
        }

        if($permiso3 && $enter_if == 0){
            $enter_if = 1;
            $seguimientos = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('seguimientos.*')
                                        ->where('tema_user.user_id', '=', $this->id_user)->get();
            return json_encode($seguimientos);
        } 
    }
    
    public function search_item($item){
        $seguimientos = Seguimiento::where('tema_id', '=', $item)->get();
        return json_encode($seguimientos);
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
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.index');
        $permiso3 = Auth::user()->hasPermissionTo('seguimientos_assign_them.index');

        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $seguimiento = Seguimiento::where('id', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 3){
                        $seguimiento = Seguimiento::where('tema_id', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 4){  //Fecha Rango creación 
                            $seguimiento = Seguimiento::whereBetween('created_at', [$data_search.' 00:00:00', $data_search2.' 23:59:59'])->orderBy('id','desc')->paginate(20)->withQueryString();
                        }else{
                            $seguimiento = Seguimiento::where('fecha', '=', $data_search)->orderBy('id','desc')->paginate(20)->withQueryString();
                        }
                    }
                }
            }else{
                $select_search = '1';
                $seguimiento = Seguimiento::orderBy('id','desc')->paginate(20)->withQueryString();
            }
        }

        if($permiso3 && $enter_if == 0){
            $enter_if = 1;
            if($select_search != null){
                if($select_search == 1){
                    $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                ->select('seguimientos.*')
                                                ->where('seguimientos.id', 'like', '%'.$data_search.'%')
                                                ->where('tema_user.user_id', '=', $this->id_user)
                                                ->orderBy('seguimientos.id','desc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 3){
                        $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                    ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                    ->select('seguimientos.*')
                                                    ->where('seguimientos.tema_id', '=', $data_search)
                                                    ->where('tema_user.user_id', '=', $this->id_user)
                                                    ->orderBy('seguimientos.id','desc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 4){  //Fecha Rango creación
                            $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                        ->select('seguimientos.*')
                                                        ->whereBetween('temas.created_at', [$data_search.' 00:00:00', $data_search2.' 23:59:59'])
                                                        ->where('tema_user.user_id', '=', $this->id_user)
                                                        ->orderBy('seguimientos.id','desc')->paginate(20)->withQueryString();
                        }else{
                            $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                                        ->select('seguimientos.*')
                                                        ->where('seguimientos.fecha', '=', $data_search)
                                                        ->where('tema_user.user_id', '=', $this->id_user)
                                                        ->orderBy('seguimientos.id','desc')->paginate(20)->withQueryString();
                        }
                    }
                }
            }else{
                $select_search = '1';
                $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                            ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                            ->select('seguimientos.*')
                                            ->where('tema_user.user_id', '=', $this->id_user)
                                            ->orderBy('seguimientos.id','desc')->paginate(20)->withQueryString();
            }
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('seguimiento.index', ['seguimientos'=> $seguimiento,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
    }

    public function create()
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.index');
        $permiso2 = Auth::user()->hasPermissionTo('temas_assign.index');
        $enter_if = 0;
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::all();
        }
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('temas.*','tema_user.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->get();
        }

        $estados = Estado_seguimiento::all();
    
        $them = (isset($_GET['tema'])?$_GET['tema']:0);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        if($them == 0){
            return view('seguimiento.create',['estados'=> $estados,'temas'=> $temas, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view('seguimiento.createSegTema',['estados'=> $estados,'temas'=> $temas, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page, 'them'=>$them]);
        }
    }

    public function store(StoreSeguimientos $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));

        $seguimiento = new Seguimiento();
        $seguimiento->seguimiento = $validated['seguimiento'];
        $seguimiento->fecha_cumplimiento = $validated['fecha_cumplimiento'];
        $seguimiento->ponderacion = $validated['ponderacion'];
        $seguimiento->avance = $validated['avance'];
        $seguimiento->tema_id = $validated['tema_id'];
        $seguimiento->estado_id = $validated['estado_id'];
        $seguimiento->save();
        
        if($request->file('evidencia') != null){
            foreach ($validated['evidencia'] as $key => $file){
                $path = public_path() . '/evidencia';
                $fileName = "Seguimiento-".uniqid() . $file->getClientOriginalName();
                $file->move($path, $fileName);

                $evidencia = new Seguimiento_archivo();
                $evidencia->seguimiento_id =  intval($seguimiento->id);
                $evidencia->evidencia =  $fileName;
                $evidencia->save();
            }
        }

        if($seguimiento->id > 0 && trim($request->get('dificultades')) != ""){
            $users_sent_mail = User::where('state_logic','=',1)->permission('seguimientos.notification')->get('email');
            Mail::to($users_sent_mail)->send(new DificultadesSeguimiento($seguimiento));
        }

        $request->session()->flash('status','Actividad creada correctamente');
        
        if(isset($datos[4])){
            return redirect()->route('temas.index', ['select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }else{
            return redirect()->route('seguimientos.index', ['seguimientos'=> $seguimiento,'select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }
    }

    public function edit($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('temas.index');
        $permiso2 = Auth::user()->hasPermissionTo('temas_assign.index');
        $enter_if = 0;
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::all();
        }
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $temas = Tema::join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('temas.*','tema_user.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->get();
        }

        $estados = Estado_seguimiento::all();

        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.edit');
        $permiso2 = Auth::user()->hasPermissionTo('seguimientos_assign_them.edit');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $seguimiento = Seguimiento::findOrFail($id);
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('seguimientos.*')
                                        ->where('tema_user.user_id', '=', $this->id_user)->get();
            $seguimiento = $seguimiento[0];
        }

        if($enter_if == 1 && isset($seguimiento->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $data_search2 = $_GET['data_search2'];
            $this->page  = $_GET['page'];

            return view('seguimiento.edit',['seguimiento'=> $seguimiento, 'estados'=> $estados,'temas'=> $temas,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function update(StoreSeguimientos $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));
        
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.edit');
        $permiso2 = Auth::user()->hasPermissionTo('seguimientos_assign_them.edit');
        $enter_if = 0;
        
        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $validated = $request->validated();

            $seguimiento = Seguimiento::findOrFail($id);
            $seguimiento->seguimiento = $validated['seguimiento'];
            $seguimiento->fecha_cumplimiento = $validated['fecha_cumplimiento'];
            $seguimiento->ponderacion = $validated['ponderacion'];
            $seguimiento->avance = $validated['avance'];
            $seguimiento->tema_id = $validated['tema_id'];
            $seguimiento->estado_id = $validated['estado_id'];
            $seguimiento->save();
            
            Seguimiento_archivo::where('seguimiento_id','=',$id)->delete();

            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $evidencia = new Seguimiento_archivo();
                    $evidencia->seguimiento_id =  intval($id);
                    $evidencia->evidencia =  $input_evidence;
                    $evidencia->save();
                }
            }

            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);

                    $evidencia = new Seguimiento_archivo();
                    $evidencia->seguimiento_id =  intval($id);
                    $evidencia->evidencia =  $fileName;
                    $evidencia->save();   
                }
            }

            $request->session()->flash('status','Actividad actualizada correctamente');
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $validated = $request->validated();

            $seg = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                                        ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                                        ->select('seguimientos.*')
                                        ->where('tema_user.user_id', '=', $this->id_user)->get();
            $seguimiento = $seg[0];
            $seguimiento->seguimiento = $validated['seguimiento'];
            $seguimiento->fecha_cumplimiento = $validated['fecha_cumplimiento'];
            $seguimiento->ponderacion = $validated['ponderacion'];
            $seguimiento->avance = $validated['avance'];
            $seguimiento->tema_id = $validated['tema_id'];
            $seguimiento->estado_id = $validated['estado_id'];
            $seguimiento->save();
            
            Seguimiento_archivo::where('seguimiento_id','=',$id)->delete();

            if($request->get('evidencia_inicial') != null){
                foreach ($request->get('evidencia_inicial') as $key => $input_evidence){
                    $evidencia = new Seguimiento_archivo();
                    $evidencia->seguimiento_id =  intval($id);
                    $evidencia->evidencia =  $input_evidence;
                    $evidencia->save();
                }
            }

            if($request->file('evidencia') != null){
                foreach ($request->file('evidencia') as $key => $file_evidence){
                    $path = public_path() . '/evidencia';
                    $fileName = uniqid() . $file_evidence->getClientOriginalName();
                    $file_evidence->move($path, $fileName);

                    $evidencia = new Seguimiento_archivo();
                    $evidencia->seguimiento_id =  intval($id);
                    $evidencia->evidencia =  $fileName;
                    $evidencia->save();   
                }
            }

            $request->session()->flash('status','Actividad actualizada correctamente');
        }

        if($enter_if == 1 && isset($seguimiento->id)){
            return redirect()->route('seguimientos.edit',['seguimiento'=> $seguimiento,'select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }else{
            return view("error.Error403");
        }
    }

    public function show($id)
    {
        $seguimiento = Seguimiento::findOrFail($id);

        $act = (isset($_GET['act'])?$_GET['act']:0);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $data_search2 = $_GET['data_search2'];
        $this->page  = $_GET['page'];

        if($act == 0){
            return view('seguimiento.show',['seguimiento'=> $seguimiento,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view('seguimiento.showSegAct',['seguimiento'=> $seguimiento,'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page, 'act'=>$act]);
        } 
    }

    public function confirmDelete($id)
    {
        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.destroy');
        $permiso2 = Auth::user()->hasPermissionTo('seguimientos_assign_them.destroy');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $seguimiento = Seguimiento::findOrFail($id);
        }

        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                            ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('seguimientos.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->get();
            $seguimiento = $seguimiento[0];
        }
        
        if($enter_if == 1 && isset($seguimiento->id)){
            $select_search = $_GET['select_search'];
            $data_search = $_GET['data_search'];
            $data_search2 = $_GET['data_search2'];
            $this->page  = $_GET['page'];
            
            return view('seguimiento.confirmDelete',['seguimiento'=> $seguimiento, 'select_search'=>$select_search,'data_search'=>$data_search,'data_search2'=>$data_search2,'page'=> $this->page]);
        }else{
            return view("error.Error403");
        }
    }

    public function destroy(Request $request,$id)
    {
        $datos = explode(";", trim($_POST['url']));

        $this->id_user = Auth::user()->id;
        $permiso1 = Auth::user()->hasPermissionTo('seguimientos.destroy');
        $permiso2 = Auth::user()->hasPermissionTo('seguimientos_assign_them.destroy');
        $enter_if = 0;

        if($permiso1 && $enter_if == 0){
            $enter_if = 1;
            $seguimiento = Seguimiento::findOrFail($id);
        }
      
        if($permiso2 && $enter_if == 0){
            $enter_if = 1;
            $seguimiento = Seguimiento::join('temas','temas.id', '=', 'seguimientos.tema_id')
                            ->join('tema_user','tema_user.tema_id', '=', 'temas.id')
                            ->select('seguimientos.*')
                            ->where('tema_user.user_id', '=', $this->id_user)->get();
            $seguimiento = $seguimiento[0];
        }

        if($enter_if == 1 && isset($seguimiento->id)){
            try {
                $seguimiento->delete();
                $request->session()->flash('status','Actividad con id '.$id.' eliminada correctamente');
            }catch (\Illuminate\Database\QueryException $e) {
                $request->session()->flash('status','Actividad con id '.$id.' no se puede eliminar dado que varias gestiones dependen de él');
            }

            return redirect()->route('seguimientos.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'data_search2'=>$datos[2],'page'=> $datos[3]]);
        }else{
            return view("error.Error403");
        }
    }
}
