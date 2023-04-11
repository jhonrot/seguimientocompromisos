<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoles;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public $page;

    public function __construct(){
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only('create','store');
        $this->middleware('can:roles.edit')->only('edit','update');
    }

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function index(Request $request)
    {
        //$role = Role::all();
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));
        if($select_search != null){
            if($select_search == 1){
                $role = Role::where('id', 'like', '%'.$data_search.'%')->orderBy('id','asc')->paginate(20)->withQueryString();
            }else{
                $role = Role::where('name', 'like', '%'.$data_search.'%')->orderBy('id','asc')->paginate(20)->withQueryString();
            }
        }else{
            $select_search = '1';
            $role = Role::orderBy('id','asc')->paginate(20)->withQueryString();
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('role.index', ['roles'=> $role,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);;
    }

    public function create()
    {
        $permissions = Permission::select('permissions.*')->orderBy('name','asc')->get();

        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('role.create',['permissions'=> $permissions,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }
     
    public function store(StoreRoles $request)
    {
        $validated = $request->validated();

        $datos = explode(";", trim($request->get('url')));
        
        $rol = new Role();
        $rol->name = $validated['name'];
        $rol->save();

        $rol->permissions()->sync($request->get('permissions'));

        $request->session()->flash('status','Rol creado correctamente');
        return redirect()->route('roles.create',['select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

    public function edit($id)
    {
        $permissions = Permission::select('permissions.id', 'permissions.name', 'permissions.description','t1.role_id')
                
                        ->leftjoin(DB::raw('(select permission_id,role_id from role_has_permissions where role_id='.$id.') t1'), 
                        function($join)
                        {
                            $join->on('permissions.id', '=', 't1.permission_id');
                        })->orderby('permissions.name','asc')
                        ->get();

        $rol = Role::findOrFail($id);
        $select_search = $_GET['select_search'];
        $data_search = $_GET['data_search'];
        $this->page  = $_GET['page'];

        return view('role.edit',['rol'=> $rol,'permissions'=> $permissions,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    public function update(StoreRoles $request, $id)
    {
        $datos = explode(";", trim($request->get('url')));

        $validated = $request->validated();

        $rol = Role::findOrFail($id);

        if($request->get('name')!=$request->get('name_origin')){
            $rol->name = $validated['name'];
        }
        $rol->permissions()->sync($request->get('permissions'));
        $rol->save();

        $permissions = Permission::select('permissions.id', 'permissions.name', 'permissions.description','t1.role_id')
                
                        ->leftjoin(DB::raw('(select permission_id,role_id from role_has_permissions where role_id='.$id.') t1'), 
                        function($join)
                        {
                            $join->on('permissions.id', '=', 't1.permission_id');
                        })->orderby('permissions.id','asc')
                        ->get();

        $request->session()->flash('status','Rol actualizado correctamente');
        return view('role.edit',['rol'=> $rol,'permissions'=> $permissions,'select_search'=>$datos[0],'data_search'=>$datos[1],'page'=> $datos[2]]);
    }

}
