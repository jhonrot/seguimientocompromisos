<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{

    public $page;

    /*public function __construct(){
        $this->middleware('can:auditoria.index')->only('index');
    }*/

    public function obtener_pagina($url)
    {
        $partes = explode("page=", $url);
        return (isset($partes[1])?$partes[1]:1);
    }

    public function index(Request $request)
    {
        $select_search = $request->get('select_search');
        $data_search = trim($request->get('data_search'));

        if($select_search != null){
            if($select_search == 1){
                $audits = Audit::where('event', 'like', '%'.$data_search.'%')->orderBy('id','asc')->paginate(20)->withQueryString();
            }else{
                if($select_search == 2){
                    $audits = Audit::where('user_id', '=', $data_search)->orderBy('id','asc')->paginate(20)->withQueryString();
                }else{
                    if($select_search == 3){
                        $audits = Audit::where('auditable_type', '=', $data_search)->orderBy('id','asc')->paginate(20)->withQueryString();
                    }else{
                        if($select_search == 4){
                            $audits = Audit::where('auditable_id', '=', $data_search)->orderBy('id','asc')->paginate(20)->withQueryString();
                        }else{
                            if($select_search == 5){
                                $audits = Audit::where('old_values', 'like', '%'.$data_search.'%')
                                        ->orwhere('new_values', 'like', '%'.$data_search.'%')
                                        ->orderBy('id','asc')->paginate(20)->withQueryString();
                            }else{
                                $audits = Audit::where('created_at', '=', $data_search)->orderBy('id','asc')->paginate(20)->withQueryString();
                            }
                        }
                    }
                }
            }
        }else{
            $select_search = '1';
            $audits = Audit::orderBy('id','asc')->paginate(20)->withQueryString();
        }

        $this->page = $this->obtener_pagina($_SERVER["REQUEST_URI"]);
        return view('audit.index', ['audits'=> $audits,'select_search'=>$select_search,'data_search'=>$data_search,'page'=> $this->page]);
    }

    /*public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }*/
}
