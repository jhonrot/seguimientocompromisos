<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\User;
use App\Tema as AppTema;
use App\Organismo;
use App\Equipo_trabajo;

class dashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

        $organismos = Organismo::all();
        $equipotrabajo = Equipo_trabajo::all();
        // dd($organismos[0]->users[0]->temas);
        // dd($organismos[0]->users[0]->asignador);
        $cantCompUser = User::all(); //cantidad de compromisos por usuario
        $compromisos = AppTema::all();
        $actual = date('Y-m-d');
        $tema = AppTema:: all();
        $estado1 = AppTema::where('estado_id','1')->where('fecha_cumplimiento','<',$actual)->count();//incumplidos
        $estado2 = AppTema::where('estado_id','2')->count();//pendientes
        $estado3 = AppTema::where('estado_id','3')->count();//cumplidos
        $fueraFecha = AppTema:: where('estado_id','3')->where('fecha_cumplimiento','<',$actual)->count();// fuera de fecha
        $total = $estado1 + $estado2 + $estado3 + $fueraFecha;
        $cumplidos = [];

        foreach($tema as $compromiso){
            if($compromiso->estado_id == 3){
                $cumplidos[] = ['name'=>$compromiso['tema'], 'y'=>intval(10)];
                
            }
        }

        $incumplidos = [];
        foreach($tema as $compromiso){
            if($compromiso->estado_id == 1 && $compromiso->fecha_cumplimiento < $actual){
                $incumplidos[] = ['name'=>$compromiso['tema'], 'y'=>intval(10)];
            }
        }
        
        $fechaFuera = [];
        foreach($tema as $compromiso){
            if($compromiso->estado_id == 3 && $compromiso->fecha_cumplimiento < $actual){
                $fechaFuera[] = ['name'=>$compromiso['tema'], 'y'=>intval(10)];
            }
        }

        $pendientes = [];
        foreach($tema as $compromiso){
            if($compromiso->estado_id == 2){
                $pendientes[] = ['name'=>$compromiso['tema'], 'y'=>intval(10)];
            }
        }

        //Cantidad de compromisos por usuario
        $userCom = [];
        foreach($cantCompUser as $user){
            if(count($user->temas)>0){
                $userCom[] = ['name'=>$user['name'],'drilldown'=>$user['id'],'y'=>(count($user->temas))];
            }
        }

        //compromisos de cada usuario
        $compUser = [];
        foreach($cantCompUser as $user){
            if(count($user->temas)>0){

                $drilldown = [];
                foreach($user->temas as $tema_user){
                    $drilldown[] = [$tema_user->tema, 10];

                }
                $compUser[] = ['name'=>$user['name'],'id'=>$user['id'],'data'=>$drilldown];
            }
        }

        //Cantidad de equipos de trabajo
        $equiposTrabajo = [];
        foreach($equipotrabajo as $equipo){
            $equiposTrabajo[] = ['name'=>$equipo['descripcion'],'drilldown'=>$equipo['id'],'y'=>(count($equipo->users))];
        }

        //usuarios de un equipo de trabajo
        $usersEquipo = [];
        foreach($equipotrabajo as $equipo){
            $drilldownUsers = [];
            foreach($equipo->users as $equipo_user){
                $drilldownUsers[] = [$equipo_user->name, 10];
            }
            $usersEquipo[] = ['name'=>$equipo['descripcion'],'id'=>$equipo['id'],'data'=>$drilldownUsers];
        }

        //organismos
        $organismosColeccion = [];
        foreach($organismos as $organismo){
            $cantCompromisos = 0;
            foreach($organismo->users as $userOrg){
                $cantCompromisos =($cantCompromisos+count($userOrg->temas));
            }
            $organismosColeccion[] = ['name'=>$organismo['name'],'y'=>($cantCompromisos)];
        }
        
        return view("seguimiento.dashboard",["cumplidos" => json_encode($cumplidos),
        "incumplidos" => json_encode($incumplidos),
        "fechaFuera" => json_encode($fechaFuera),
        "pendientes" => json_encode($pendientes),
        "responsables" => json_encode($userCom),
        "temasUser" => json_encode($compUser),
        "equipos" => json_encode($equiposTrabajo),
        "userEquipos" => json_encode($usersEquipo),
        "organismosCol" => json_encode($organismosColeccion)
        ],
        compact('estado1','estado2','estado3','total','fueraFecha','tema','compromisos','cantCompUser','organismos','equipotrabajo'));
        
    }
}