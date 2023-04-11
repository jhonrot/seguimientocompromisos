<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Equipo_trabajo;
use App\Organismo;
use App\Asistente;
use App\Http\Requests\StoreUsers;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoValidado;

class UserController extends Controller
{

    public $page;

    public function __construct(){
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.create')->only('create','store');
        $this->middleware('can:users.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function search(){
        $responsables = User::select('id', 'num_document', 'name','last_name','organismo_id')
                            ->where('state_logic', '=', '1')->orderBy('name','asc')->get();
        
        return json_encode($responsables);
    }
    
    public function search_users_asistentes(){
        $responsables = User::select(DB::raw("CONCAT(name,' ',last_name) AS name"))->where('state_logic', '=', '1');
        $asistentes = Asistente::select("name_full as name")->union($responsables)->get();
        
        return json_encode($asistentes);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $userSis = User::where('name', 'like', '%'.$data_search.'%')->orwhere('last_name', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
            }else{
                if($select_search == 2){
                    $userSis = User::where('email', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }else{
                    $userSis = User::where('num_document', 'like', '%'.$data_search.'%')->orderBy('id','desc')->paginate(20)->withQueryString();
                }
            }
        }else{
            $select_search = '1';
            $userSis = User::orderBy('id','desc')->paginate(20)->withQueryString();
        }
        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('user.index', ['users'=> $userSis,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function create()
    {
        $roles = Role::all();
        $equipo = Equipo_trabajo::all();
        $organismo = Organismo::all();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];
        return view('user.create',['roles'=> $roles,'equipo'=> $equipo,'organismo'=> $organismo,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function store(StoreUsers $request) 
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $user = new User();
        $user->name = $validated['name'];
        $user->last_name = $validated['last_name'];
        $user->type_document = $validated['type_document'];
        $user->num_document = $validated['num_document'];
        $user->state = $validated['state'];
        $user->state_logic = $validated['state_logic'];
        $user->telefono = $validated['telefono'];
        $user->celular = $validated['celular'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        if($request->has('roles')){
            $user->assignRole($request->get('roles'));
        }
        $user->equipo_trabajo_id = $request->get('equipo_trabajo_id');
        $user->organismo_id = $request->get('organismo_id');

        if($request->file('foto') != null){
            $file = $request->file('foto');
            $path = public_path() . '/fotos';
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($path, $fileName);

            $user->foto =  $fileName;
        }

        $user->save();

        Mail::to($user)->send(new CorreoValidado($user));

        $request->session()->flash('status','Usuario creado correctamente');
        return redirect()->route('users.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $equipo = Equipo_trabajo::all();
        $organismo = Organismo::all();

        $user = User::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('user.edit',['user'=> $user,'roles'=> $roles,'equipo'=> $equipo,'organismo'=> $organismo,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreUsers $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));
        
        if($request->has('roles')){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
        }
        
        $validated = $request->validated();

        $fileName = null;
        if($request->file('foto') != null){
            $file = $request->file('foto');
            $path = public_path() . '/fotos';
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($path, $fileName);
        }

        if($request->get('foto_inicial') != ''){
            $fileName = $request->get('foto_inicial');
        }

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->last_name = $validated['last_name'];
        $user->type_document = $validated['type_document'];
        if($request->get('num_document')!=$request->get('num_document_origin')){
            $user->num_document = $validated['num_document'];
        }
        $user->state = $request->get('state');
        $user->state_logic = $request->get('state_logic');
        $user->telefono = $validated['telefono'];
        $user->celular = $validated['celular'];
        if($request->get('email')!=$request->get('email_origin')){
            $user->email = $validated['email'];
        }
        if($request->get('password')!="" || $request->get('password-confirm')!=""){
            $user->password = Hash::make($validated['password']);
        }
        if($request->has('roles')){
            $user->assignRole($request->get('roles'));
        }

        $user->equipo_trabajo_id = $request->get('equipo_trabajo_id');
        $user->organismo_id = $request->get('organismo_id');
        $user->foto = $fileName;

        $user->save();

        $request->session()->flash('status','Usuario actualizado correctamente');
        return redirect()->route('users.edit',['user'=> $user,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function profile($id)
    {
        $id_user_login = Auth::user()->id;
        if($id_user_login!=$id){
            $id = 0;
        }
        $user = User::findOrFail($id);

        return view('user.profile',['user'=> $user]);
    }

    public function updateProfile(StoreUsers $request, $id)
    {   
        $id_user_login = Auth::user()->id;
        if($id_user_login!=$id){
            $id = 0;
        }

        $validated = $request->validated();

        $fileName = null;
        if($request->file('foto') != null){
            $file = $request->file('foto');
            $path = public_path() . '/fotos';
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($path, $fileName);
        }

        if($request->get('foto_inicial') != ''){
            $fileName = $request->get('foto_inicial');
        }

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->last_name = $validated['last_name'];
        $user->telefono = $validated['telefono'];
        $user->celular = $validated['celular'];
        if($request->get('email')!=$request->get('email_origin')){
            $user->email = $validated['email'];
        }
        if($request->get('password')!="" || $request->get('password-confirm')!=""){
            $user->password = Hash::make($validated['password']);
        }
        $user->foto = $fileName;
        $user->save();

        $request->session()->flash('status','Perfil actualizado correctamente');

        return redirect()->route('users.profile',['id'=> $id]);
    }

}
