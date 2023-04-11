<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea;
use App\Plan_actividad;
use App\Periodo;
use App\Tarea_archivo;
use App\Http\Requests\StoreTareas;

class TareaController extends Controller
{
    public $page;

    public function __construct(){
        $this->middleware('can:tareas.index')->only('index');
        $this->middleware('can:tareas.create')->only('create','store');
        $this->middleware('can:tareas.edit')->only('edit','update');
        $this->middleware('can:tareas.destroy')->only('confirmDelete','destroy');
    }

    public function index()
    {
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $page  = $_GET['page'];
        $actividad  = $_GET['actividad'];

        $tareas = Tarea::where('plan_actividad_id', '=', $actividad)->orderBy('id','desc');

        return view('tarea.index', ['tareas'=> $tareas,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $page, 'actividad'=>$actividad]);
    }

    public function create()
    {
        $actividad  = $_GET['actividad'];

        $actividades = Plan_actividad::where('id', '=', $actividad)->get();
        $periodos = Periodo::all();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $page  = $_GET['page'];

        return view('tarea.create',['actividades'=>$actividades,'periodos'=>$periodos,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $page, 'actividad'=>$actividad]);
    }

    public function store(StoreTareas $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $tarea = new Tarea();
        $tarea->tarea = $validated['tarea'];
        $tarea->meta = $validated['meta'];
        $tarea->avance_indicador = $validated['avance_indicador'];
        $tarea->vigencia = ' ';
        $tarea->mes = ' ';
        $tarea->plan_actividad_id = $validated['plan_actividad_id'];
        $tarea->periodo_id = $validated['periodo_id'];
        $tarea->save();

        if($request->file('evidencia') != null){
            foreach ($validated['evidencia'] as $key => $file){
                $path = public_path() . '/evidencia';
                $fileName = "Tarea" . uniqid() . $file->getClientOriginalName();
                $file->move($path, $fileName);

                $evidencia = new Tarea_archivo();
                $evidencia->tarea_id =  intval($tarea->id);
                $evidencia->evidencia =  $fileName;
                $evidencia->save();
            }
        }

        $request->session()->flash('status','Tarea creada correctamente');
        return redirect()->route('tareas.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2], 'actividad'=>$datos[3]]);
    }

    public function edit($id)
    {
        $periodos = Periodo::all();

        $plan = Plan_actividad::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $page  = $_GET['page'];
        $actividad  = $_GET['actividad'];

        return view('plan.edit',['periodos'=>$periodos,'plan'=> $plan,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $page, 'actividad'=>$actividad]);
    }

    public function update(StoreTareas $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $tarea = Tarea::findOrFail($id);
        $tarea->tarea = $validated['tarea'];
        $tarea->meta = $validated['meta'];
        $tarea->indicador = $validated['indicador'];
        $tarea->unidad = $validated['unidad'];
        $tarea->evidencia = $validated['evidencia'];
        $tarea->vigencia = $validated['vigencia'];
        $tarea->mes = $validated['mes'];
        $tarea->periodo_id = $validated['periodo_id'];
        $tarea->save();

        $request->session()->flash('status','Tarea actualizada correctamente');
        return redirect()->route('tareas.edit',['tarea'=> $tarea,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'actividad'=> $datos[3]]);
    }

    public function confirmDelete($id)
    {
        $tarea = Tarea::findOrFail($id);

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $page  = $_GET['page'];
        $actividad  = $_GET['actividad'];
    
        return view('tarea.confirmDelete',['tarea'=> $tarea, 'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $page,'actividad'=> $actividad]);
    }

    public function destroy(Request $request,$id)
    {
        $datos = explode(";", trim($_POST['url']));

        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        $request->session()->flash('status','Tarea con id '.$id.' eliminada correctamente');

        return redirect()->route('tareas.index',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2],'actividad'=> $datos[3]]);    
    }
}
