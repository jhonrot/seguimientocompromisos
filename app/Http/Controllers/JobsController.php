<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Organismo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class JobsController extends Controller
{
    public $part;
    
    public function insertUsers(Request $request)
    {
        $this->part = $request->get('part');
    
        /*session_start();
        
        if(isset($_SESSION["part"])){
            $this->part = intval($_SESSION["part"])+1;
            $_SESSION["part"] = $this->part;
        }else{
            $this->part = 1;
            $_SESSION["part"] = $this->part;
        }*/
        
        $api_token = env('API_ENDPOINT_TOKEN');
        $api_users = env('API_ENDPOINT_USERS');

        $token = new Client([
            'base_uri' => $api_token,
            'timeout' => 2.0,
        ]);

        $get_token = $token->post('', [
            'json' => [
                'usuario' => 'admin@sgsc.com',
                'clave' => 'WE4B83JCN5B80CNDBG8678BVMAMZZP',
            ]
        ]);
        
        $dato_token = json_decode($get_token->getBody()->getContents());
        $dato_token = $dato_token->token;

        $users = new Client([
            'base_uri' => $api_users,
            'timeout' => 200000,
        ]);

        $get_users = $users->post('', [
            'headers' => [ 'Authorization' => 'Bearer ' . $dato_token ],
            'json' => [
                'nombre' => '%%',
            ]
        ]);

        $datos_users = json_decode($get_users->getBody()->getContents());

        $cantidad_usuarios = count($datos_users);
        $insert_update = 0;
        
        $div = ceil($cantidad_usuarios > 5000?($cantidad_usuarios/5000):$cantidad_usuarios);
        $las_part = ($cantidad_usuarios -(($div-1)*5000));
        
        $desde = (($this->part-1) * 5000);
        
        if($this->part==$div){
            $hasta = $cantidad_usuarios;
            //$this->part = 0;
            //$_SESSION["part"] = $this->part;
        }else{
            $hasta = ($this->part * 5000);
        }
        
        Log::channel('notifies')->info('Actualización paquete '.$this->part.' ('.$div.','.$cantidad_usuarios.','.$desde.','.$hasta.','.$las_part.'   ) de usuarios endpoint');
        
        for($i=$desde;$i<$hasta;$i++){
            $cedula = $datos_users[$i]->identificacion;

            $nombres_todo = (explode(" ",$datos_users[$i]->nombres));
            $cant_total_nombres_todo = count($nombres_todo);
            $nombre = $nombres_todo[0]." ".($cant_total_nombres_todo >=3?$nombres_todo[1]:'');
            $apellido = ($cant_total_nombres_todo >=3?$nombres_todo[2]:"");
            $telefono = $datos_users[$i]->telefono;
            $email = $datos_users[$i]->email;
            $contrasenia_enter_api = $datos_users[$i]->contrasena;
            $estado = $datos_users[$i]->estado=="Habilitado"?1:2;
            $organismo = trim($datos_users[$i]->organismo);

            $user_alcaldia = User::where('num_document', '=', $cedula)->orwhere('email', '=', $email)->get();

            if(count($user_alcaldia) > 0){
                
                $org = Organismo::where('name', '=', $organismo)->get();
                if(count($org)>0){
                    $organismo_id = $org[0]->id;
                }else{
                    $org = new Organismo();
                    $org->name = $organismo;
                    $org->save();

                    $organismo_id = $org->id;
                }
                
                $insert_update++;
                $user = User::findOrFail($user_alcaldia[0]->id);
                $user->state = $estado;
                $user->state_logic = $estado;
                $user->organismo_id = $organismo_id;
                $user->save();
            }else{
                if($estado == 1 && $email != ""){
                    
                    $org = Organismo::where('name', '=', $organismo)->get();
                    if(count($org)>0){
                        $organismo_id = $org[0]->id;
                    }else{
                        $org = new Organismo();
                        $org->name = $organismo;
                        $org->save();

                        $organismo_id = $org->id;
                    }
                    
                    $insert_update++;
                    $user = new User();
                    $user->name = $nombre;
                    $user->last_name = $apellido;
                    $user->type_document = 1;
                    $user->num_document = $cedula;
                    $user->state = $estado;
                    $user->state_logic = $estado;
                    $user->telefono = $telefono;
                    $user->email = $email;
                    $user->password = $contrasenia_enter_api;
                    $user->organismo_id = $organismo_id;
                    $user->assignRole(array(0 => "12"));
                    $user->save();
                }
            }
        }
        print $this->part.";".$div.";".$cantidad_usuarios.";".$desde.";".$hasta.";".$las_part;  //($this->part-1).";".$div.";".$div.";".$cantidad_usuarios;
    }
}
