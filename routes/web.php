<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
App::setLocale("es");

Auth::routes([
    'register' => false
]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/', 'HomeController@index')->name('index_home')->middleware('auth');

Route::resource('/users', 'UserController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/users/profile/{id}/edit', 'UserController@profile')->name('users.profile')->middleware('auth');
Route::PUT('/users/profile/{id}', 'UserController@updateProfile')->name('users.updateProfile')->middleware('auth');
Route::get('/users/search/resp','UserController@search')->name('users.search')->middleware('auth');
Route::get('/users/search/asistentes','UserController@search_users_asistentes')->name('users_asistentes.search')->middleware('auth');

Route::resource('/roles', 'RoleController')->only(['index','create','store','edit','update'])->middleware('auth');

Route::resource('/temas', 'TemaController')->only(['index','edit','update','show', 'destroy'])->middleware('auth');
Route::get('/temas/{id}/confirmDelete','TemaController@confirmDelete')->name('temas.confirmDelete')->middleware('auth');
Route::get('/temas/search/them','TemaController@search')->name('temas.search')->middleware('auth');
Route::get('/temas/search/formSearch','TemaController@formSearch')->name('temas.formSearch')->middleware('auth');
Route::get('/temas/search/{item1}/{item2}/{item3}/printForm','TemaController@printForm')->name('temas.printForm')->middleware('auth');
Route::get('/temas/{id}/prinTema','TemaController@prinTema')->name('temas.prinTema')->middleware('auth');
Route::get('/temas/search/{item1}/{item2}/{item3}/printInform','TemaController@data_inform')->name('temas.data_inform')->middleware('auth');
Route::get('/temas/search/nextDateNotification','TemaController@notification_vencimiento_tema')->name('temas.notification_vencimiento_tema');
Route::get('/temas/search/{item}/reporte','TemaController@print_reporte')->name('temas.print_reporte')->middleware('auth');

Route::resource('/seguimientos', 'SeguimientoController')->only(['index','create','store','edit','update','show', 'destroy'])->middleware('auth');
Route::get('/seguimientos/{id}/confirmDelete','SeguimientoController@confirmDelete')->name('seguimientos.confirmDelete')->middleware('auth');
Route::get('/seguimientos/search/seg','SeguimientoController@search')->name('seguimientos.search')->middleware('auth');
Route::get('/seguimientos/search/{item}/item','SeguimientoController@search_item')->name('seguimientos.search_item')->middleware('auth');

Route::resource('/equipos', 'Equipo_trabajoController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/equipos/search/ind','Equipo_trabajoController@search')->name('equipos.search')->middleware('auth');

Route::resource('/organismos', 'OrganismoController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/organismos/search/resp','OrganismoController@search')->name('organismos.search')->middleware('auth');

Route::resource('/prioridades', 'PrioridadController')->only(['index','create','store','edit','update'])->middleware('auth');

Route::resource('/clasificaciones', 'ClasificacionController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/clasificaciones/search/clas','ClasificacionController@search')->name('clasificaciones.search')->middleware('auth');
Route::get('/clasificaciones/search/{item}/datos','ClasificacionController@search_item')->name('clasificaciones.search_item')->middleware('auth');

Route::resource('/estado_seguimientos', 'Estado_seguimientoController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/estado_seguimientos/search/estado','Estado_seguimientoController@search')->name('estado_seguimientos.search')->middleware('auth');

Route::resource('/helps', 'RequerimientoController')->only(['index','create','store','edit','update','show'])->middleware('auth');

Route::resource('/comunas', 'ComunaController')->only(['index','create','store','edit','update'])->middleware('auth');

Route::resource('/modalidades', 'ModalidadController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/modalidades/search/mod','ModalidadController@search')->name('modalidades.search')->middleware('auth');

Route::resource('/proyectos', 'ProyectoController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::get('/proyectos/search/proj','ProyectoController@search')->name('proyectos.search')->middleware('auth');

Route::get('/proyectos/view/registry','ProyectoController@registry')->name('proyectos.registry')->middleware('auth');

Route::resource('/paas', 'PaaController')->only(['index','create','store','edit','update'])->middleware('auth');

Route::resource('/precontractuales', 'PrecontractualController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::resource('/ejecuciones', 'EjecucionController')->only(['index','create','store','edit','update'])->middleware('auth');

Route::resource('/tema_despachos', 'Tema_despachoController')->only(['index','create','store','edit','update','destroy','show'])->middleware('auth');
Route::get('/tema_despachos/{id}/confirmDelete','Tema_despachoController@confirmDelete')->name('tema_despachos.confirmDelete')->middleware('auth');
Route::get('/tema_despachos/search/them','Tema_despachoController@search')->name('tema_despachos.search')->middleware('auth');

Route::resource('/tarea_despachos', 'Tarea_despachoController')->only(['index','create','store','edit','update','destroy','show'])->middleware('auth');
Route::get('/tarea_despachos/{id}/confirmDelete','Tarea_despachoController@confirmDelete')->name('tarea_despachos.confirmDelete')->middleware('auth');
Route::get('/tema_despachos/search/{item1}/{item2}/{item3}/print','Tema_despachoController@print_data')->name('tema_despachos.print_data')->middleware('auth');

Route::resource('/indices', 'IndiceController')->only(['index','create','store','edit','update', 'destroy'])->middleware('auth');
Route::get('/indices/{id}/confirmDelete','IndiceController@confirmDelete')->name('indices.confirmDelete')->middleware('auth');
Route::get('/indices/search/ind','IndiceController@search')->name('indices.search')->middleware('auth');
Route::get('/indices/search/{item}/datos','IndiceController@search_item')->name('indices.search_item')->middleware('auth');

Route::resource('/sub_clasificaciones', 'Sub_clasificacionController')->only(['index','create','store','edit','update', 'destroy'])->middleware('auth');
Route::get('/sub_clasificaciones/{id}/confirmDelete','Sub_clasificacionController@confirmDelete')->name('sub_clasificaciones.confirmDelete')->middleware('auth');
Route::get('/sub_clasificaciones/search/{item}/datos','Sub_clasificacionController@search')->name('sub_clasificaciones.search')->middleware('auth');
Route::get('/sub_clasificaciones/search/datos','Sub_clasificacionController@search_all')->name('sub_clasificaciones.search_all')->middleware('auth');
Route::get('/sub_clasificaciones/form/create','Sub_clasificacionController@form_create')->name('sub_clasificaciones.form_create')->middleware('auth');
Route::post('/sub_clasificaciones/form/create_store','Sub_clasificacionController@form_store')->name('sub_clasificaciones.form_store')->middleware('auth');

Route::resource('/actividades', 'ActividadController')->only(['index','create','store','edit','update','show', 'destroy'])->middleware('auth');
Route::get('/actividades/{id}/confirmDelete','ActividadController@confirmDelete')->name('actividades.confirmDelete')->middleware('auth');
Route::get('/actividades/informe/principal','ActividadController@generate')->name('actividades.generate')->middleware('auth');
Route::get('/actividades/search/{item}/item','ActividadController@search_item')->name('actividades.search_item')->middleware('auth');
Route::get('/actividades/search/{item1}/{item2}/{item3}/{item4}/print','ActividadController@print_data')->name('actividades.print_data')->middleware('auth');

Route::resource('/procesos', 'ProcesoController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::resource('/objetivos', 'ObjetivoController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::resource('/obligaciones', 'ObligacionController')->only(['index','create','store','edit','update'])->middleware('auth');
Route::resource('/periodos', 'PeriodoController')->only(['index','create','store','edit','update'])->middleware('auth');

Route::resource('/planes', 'Plan_actividadController')->only(['index','create','store','edit','update', 'show', 'destroy'])->middleware('auth');
Route::get('/planes/{id}/confirmDelete','Plan_actividadController@confirmDelete')->name('planes.confirmDelete')->middleware('auth');

Route::resource('/tareas', 'TareaController')->only(['index','create','store','edit','update', 'destroy'])->middleware('auth');
Route::get('/tareas/{id}/confirmDelete','TareaController@confirmDelete')->name('tareas.confirmDelete')->middleware('auth');

// ruta dashboard
Route::get('/dashboard', [App\Http\Controllers\dashboardController::class, 'index'])->name('seguimiento.dashboard');

// Ruta inserción y actualización de usuarios consumiendo el endpoint de gestion contractual alacaldía
Route::get('/Jobs/intUsers','JobsController@insertUsers')->name('jobsCron.insertUsers');

Route::resource('/audits', 'AuditController')->only(['index'])->middleware('auth');