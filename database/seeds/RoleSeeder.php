<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'Admin']);
        $role2 = Role::create(['name'=>'Especialista']);
        $role3 = Role::create(['name'=>'Profesional']);
        $role4 = Role::create(['name'=>'Técnico asistencial']);
        $role5 = Role::create(['name'=>'Secretaría']);

        Permission::create(['name'=>'roles.index','description'=>'Ver la lista de roles'])->syncRoles([$role1]);
        Permission::create(['name'=>'roles.create','description'=>'Crear roles'])->syncRoles([$role1]);
        Permission::create(['name'=>'roles.edit','description'=>'Editar roles'])->syncRoles([$role1]);

        Permission::create(['name'=>'users.index','description'=>'Ver lista de usuarios'])->syncRoles([$role1]);
        Permission::create(['name'=>'users.create','description'=>'Crear usuarios'])->syncRoles([$role1]);
        Permission::create(['name'=>'users.edit','description'=>'Editar usuarios'])->syncRoles([$role1]);

        Permission::create(['name'=>'temas.index','description'=>'Ver lista de todos los temas'])->syncRoles([$role1,$role5]);
        Permission::create(['name'=>'temas.create','description'=>'Crear temas'])->syncRoles([$role1,$role5]);
        Permission::create(['name'=>'temas.edit','description'=>'Editar cualquier tema'])->syncRoles([$role1,$role5]);
        Permission::create(['name'=>'temas.show','description'=>'Mostrar cualquier temas'])->syncRoles([$role1,$role4]);
        Permission::create(['name'=>'temas.destroy','description'=>'Eliminar cualquier temas'])->syncRoles([$role1,$role5]);

        Permission::create(['name'=>'temas_create.index','description'=>'Ver solo lista de temas creados por usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas_assign.index','description'=>'Ver solo lista de temas que han asignado a usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas_assign_create.index','description'=>'Ver solo lista de temas creados por usuario logueado y que han asignado a usuario logueado'])->syncRoles([$role1]);

        Permission::create(['name'=>'temas_create.edit','description'=>'Editar temas creados por usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas_assign.edit','description'=>'Editar temas que se han asignado a usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas_assign_create.edit','description'=>'Editar temas creados por usuario logueado y que se han asignado a usuario logueado'])->syncRoles([$role1]);

        Permission::create(['name'=>'temas_create.destroy','description'=>'Eliminar temas creados por usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas_assign.destroy','description'=>'Eliminar temas que se han asignado a usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas_assign_create.destroy','description'=>'Eliminar temas creados por usuario logueado y que se han asignado a usuario logueado'])->syncRoles([$role1]);

        Permission::create(['name'=>'seguimientos.index','description'=>'Ver lista de todos los seguimientos'])->syncRoles([$role1,$role4]);
        Permission::create(['name'=>'seguimientos.create','description'=>'Crear seguimiento'])->syncRoles([$role1,$role4]);
        Permission::create(['name'=>'seguimientos.edit','description'=>'Editar cualquier seguimientos'])->syncRoles([$role1,$role4]);
        Permission::create(['name'=>'seguimientos.show','description'=>'Mostrar cualquier seguimientos'])->syncRoles([$role1,$role4]);
        Permission::create(['name'=>'seguimientos.destroy','description'=>'Eliminar cualquier seguimientos'])->syncRoles([$role1,$role4]);

        Permission::create(['name'=>'seguimientos_create.index','description'=>'Ver solo lista de Seguimientos creados por usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'seguimientos_create.edit','description'=>'Editar solo Seguimientos creados por usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'seguimientos_create.destroy','description'=>'Eliminar solo Seguimientos creados por usuario logueado'])->syncRoles([$role1]);

        Permission::create(['name'=>'equipos.index','description'=>'Ver lista de equipos de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'equipos.create','description'=>'Crear equipos de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'equipos.edit','description'=>'Editar equipos de trabajo'])->syncRoles([$role1]);

        Permission::create(['name'=>'organismos.index','description'=>'Ver lista de organismos'])->syncRoles([$role1]);
        Permission::create(['name'=>'organismos.create','description'=>'Crear organismos'])->syncRoles([$role1]);
        Permission::create(['name'=>'organismos.edit','description'=>'Editar organismos'])->syncRoles([$role1]);

        Permission::create(['name'=>'prioridades.index','description'=>'Ver lista de prioridades'])->syncRoles([$role1]);
        Permission::create(['name'=>'prioridades.create','description'=>'Crear prioridades'])->syncRoles([$role1]);
        Permission::create(['name'=>'prioridades.edit','description'=>'Editar prioridades'])->syncRoles([$role1]);

        Permission::create(['name'=>'clasificaciones.index','description'=>'Ver lista de clasificaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'clasificaciones.create','description'=>'Crear clasificaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'clasificaciones.edit','description'=>'Editar clasificaciones'])->syncRoles([$role1]);

        Permission::create(['name'=>'estado_seguimientos.index','description'=>'Ver lista de estados seguimiento'])->syncRoles([$role1]);
        Permission::create(['name'=>'estado_seguimientos.create','description'=>'Crear estados seguimiento'])->syncRoles([$role1]);
        Permission::create(['name'=>'estado_seguimientos.edit','description'=>'Editar estados seguimiento'])->syncRoles([$role1]);
        
        Permission::create(['name'=>'temas.print','description'=>'Imprimir varios temas en PDF por filtro'])->syncRoles([$role1]);
        Permission::create(['name'=>'temas.inform','description'=>'Hacer informes'])->syncRoles([$role1]);

        Permission::create(['name'=>'seguimientos_assign_them.index','description'=>'Ver solo lista de seguimientos cuyos temas han sido asignados a usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'seguimientos_create_them.index','description'=>'Ver solo lista de seguimientos cuyos temas han sido creados por usuario logueado'])->syncRoles([$role1]);

        Permission::create(['name'=>'seguimientos_create_assign_them.index','description'=>'Ver solo lista de seguimientos creados por usuario logueado y cuyos temas han sido asignados a usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'seguimientos_create_create_them.index','description'=>'Ver solo lista de seguimientos creados por usuario logueado y cuyos temas han sido creados por usuario logueado'])->syncRoles([$role1]);
        Permission::create(['name'=>'seguimientos_create_assign_them_create_them.index','description'=>'Ver solo lista de seguimientos creados por usuario logueado, cuyos temas han sido asignados a usuario logueado y cuyos temas han sido creados por usuario logueado'])->syncRoles([$role1]); 
        Permission::create(['name'=>'seguimientos_assign_them_create_them.index','description'=>'Ver solo lista de seguimientos cuyos temas han sido asignados a usuario logueado y cuyos temas han sido creados por usuario logueado'])->syncRoles([$role1]);




        Permission::create(['name'=>'helps.index','description'=>'Ver lista de todos los requerimientos'])->syncRoles([$role1]);
        Permission::create(['name'=>'helps.create','description'=>'Crear requerimientos'])->syncRoles([$role1]);
        Permission::create(['name'=>'helps.edit','description'=>'Editar cualquier requerimiento'])->syncRoles([$role1]);
        Permission::create(['name'=>'helps.show','description'=>'Mostrar cualquier requerimiento'])->syncRoles([$role1]);
        
        Permission::create(['name'=>'helps_create.index','description'=>'Ver lista de requerimientos creados por usuario logueado'])->syncRoles([$role1]);





        Permission::create(['name'=>'comunas.index','description'=>'Ver lista de comunas'])->syncRoles([$role1]);
        Permission::create(['name'=>'comunas.create','description'=>'Crear comunas'])->syncRoles([$role1]);
        Permission::create(['name'=>'comunas.edit','description'=>'Editar comunas'])->syncRoles([$role1]);

        Permission::create(['name'=>'modalidades.index','description'=>'Ver lista de modalidades'])->syncRoles([$role1]);
        Permission::create(['name'=>'modalidades.create','description'=>'Crear modalidades'])->syncRoles([$role1]);
        Permission::create(['name'=>'modalidades.edit','description'=>'Editar modalidades'])->syncRoles([$role1]);






        Permission::create(['name'=>'proyectos.index','description'=>'Ver lista de todos los proyectos'])->syncRoles([$role1]);
        Permission::create(['name'=>'proyectos.create','description'=>'Crear proyectos'])->syncRoles([$role1]);
        Permission::create(['name'=>'proyectos.edit','description'=>'Editar todos los proyectos'])->syncRoles([$role1]);

        Permission::create(['name'=>'paas.index','description'=>'Ver lista de PAA'])->syncRoles([$role1]);
        Permission::create(['name'=>'paas.create','description'=>'Crear PAA'])->syncRoles([$role1]);
        Permission::create(['name'=>'paas.edit','description'=>'Editar PAA'])->syncRoles([$role1]);

        Permission::create(['name'=>'contractuals.index','description'=>'Ver lista de etapas precontractuales'])->syncRoles([$role1]);
        Permission::create(['name'=>'contractuals.create','description'=>'Crear etapas precontractuales'])->syncRoles([$role1]);
        Permission::create(['name'=>'contractuals.edit','description'=>'Editar etapas precontractuales'])->syncRoles([$role1]);

        Permission::create(['name'=>'ejecucions.index','description'=>'Ver lista de etapas de ejecuciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'ejecucions.create','description'=>'Crear etapas de ejecuciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'ejecucions.edit','description'=>'Editar etapas de ejecuciones'])->syncRoles([$role1]);

        Permission::create(['name'=>'tema_despachos.index','description'=>'Ver lista de tareas de despacho'])->syncRoles([$role1]);
        Permission::create(['name'=>'tema_despachos.create','description'=>'Crear tareas de despacho'])->syncRoles([$role1]);
        Permission::create(['name'=>'tema_despachos.edit','description'=>'Editar tareas de despacho'])->syncRoles([$role1]);

        Permission::create(['name'=>'tarea_despachos.index','description'=>'Ver lista de seguimiento tareas de despacho'])->syncRoles([$role1]);
        Permission::create(['name'=>'tarea_despachos.create','description'=>'Crear seguimiento tareas de despacho'])->syncRoles([$role1]);
        Permission::create(['name'=>'tarea_despachos.edit','description'=>'Editar seguimiento tareas de despacho'])->syncRoles([$role1]);

        Permission::create(['name'=>'proyectos_assig.index','description'=>'Ver lista de proyectos por responsables'])->syncRoles([$role1]);
        Permission::create(['name'=>'proyectos_assig.edit','description'=>'Editar proyectos por responsables'])->syncRoles([$role1]);

        Permission::create(['name'=>'tema_despachos.destroy','description'=>'Eliminar tareas de despacho'])->syncRoles([$role1]);
        Permission::create(['name'=>'tema_despachos.show','description'=>'Ver tarea de despacho'])->syncRoles([$role1]);

        Permission::create(['name'=>'tarea_despachos.destroy','description'=>'Eliminar seguimiento tareas de despacho'])->syncRoles([$role1]);
        Permission::create(['name'=>'tarea_despachos.show','description'=>'Ver seguimiento tarea de despacho'])->syncRoles([$role1]);
    
        Permission::create(['name'=>'indices.index','description'=>'Ver lista de Indices'])->syncRoles([$role1]);
        Permission::create(['name'=>'indices.create','description'=>'Crear Indices'])->syncRoles([$role1]);
        Permission::create(['name'=>'indices.edit','description'=>'Editar Indices'])->syncRoles([$role1]);
        Permission::create(['name'=>'indices.destroy','description'=>'Eliminar Indices'])->syncRoles([$role1]);

        Permission::create(['name'=>'sub_clasificaciones.index','description'=>'Ver lista de sub clasificaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'sub_clasificaciones.create','description'=>'Crear sub clasificaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'sub_clasificaciones.edit','description'=>'Editar sub clasificaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'sub_clasificaciones.destroy','description'=>'Eliminar sub clasificaciones'])->syncRoles([$role1]);
    
        Permission::create(['name'=>'temas.notification','description'=>'Notificación de temas prioridad alta'])->syncRoles();
        Permission::create(['name'=>'seguimientos.notification','description'=>'Notificación seguimiento dificultades presentadas'])->syncRoles();




        Permission::create(['name'=>'actividades.index','description'=>'Ver lista de todos las actividades'])->syncRoles([$role1,$role5]);
        Permission::create(['name'=>'actividades.create','description'=>'Crear actividades'])->syncRoles([$role1,$role5]);
        Permission::create(['name'=>'actividades.edit','description'=>'Editar cualquier actividad'])->syncRoles([$role1,$role5]);
        Permission::create(['name'=>'actividades.show','description'=>'Mostrar cualquier actividad'])->syncRoles([$role1,$role4]);
        Permission::create(['name'=>'actividades.destroy','description'=>'Eliminar cualquier actividad'])->syncRoles([$role1,$role5]);
        
        Permission::create(['name'=>'procesos.index','description'=>'Ver lista de procesos'])->syncRoles([$role1]);
        Permission::create(['name'=>'procesos.create','description'=>'Crear procesos'])->syncRoles([$role1]);
        Permission::create(['name'=>'procesos.edit','description'=>'Editar procesos'])->syncRoles([$role1]);

        Permission::create(['name'=>'objetivos.index','description'=>'Ver lista de objetivos'])->syncRoles([$role1]);
        Permission::create(['name'=>'objetivos.create','description'=>'Crear objetivos'])->syncRoles([$role1]);
        Permission::create(['name'=>'objetivos.edit','description'=>'Editar objetivos'])->syncRoles([$role1]);

        Permission::create(['name'=>'obligaciones.index','description'=>'Ver lista de obligaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'obligaciones.create','description'=>'Crear obligaciones'])->syncRoles([$role1]);
        Permission::create(['name'=>'obligaciones.edit','description'=>'Editar obligaciones'])->syncRoles([$role1]);

        Permission::create(['name'=>'periodos.index','description'=>'Ver lista de periodos'])->syncRoles([$role1]);
        Permission::create(['name'=>'periodos.create','description'=>'Crear periodos'])->syncRoles([$role1]);
        Permission::create(['name'=>'periodos.edit','description'=>'Editar periodos'])->syncRoles([$role1]);

        Permission::create(['name'=>'planes.index','description'=>'Ver lista de actividades de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'planes.create','description'=>'Crear actividades de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'planes.edit','description'=>'Editar actividades de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'planes.destroy','description'=>'Eliminar actividades de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'planes.show','description'=>'Mostrar actividades de plan de trabajo'])->syncRoles([$role1,$role4]);


        Permission::create(['name'=>'tareas.index','description'=>'Ver lista de tareas de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'tareas.create','description'=>'Crear tareas de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'tareas.edit','description'=>'Editar tareas de plan de trabajo'])->syncRoles([$role1]);
        Permission::create(['name'=>'tareas.destroy','description'=>'Eliminar tareas de plan de trabajo'])->syncRoles([$role1]);
    }
}
