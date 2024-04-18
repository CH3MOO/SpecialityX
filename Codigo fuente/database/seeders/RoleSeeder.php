<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role1=Role::create(['name'=>'Administrador']);
        $role2=Role::create(['name'=>'Secretaria']);
        $role3=Role::create(['name'=>'SoloTickets']);
        $role4=Role::create(['name'=>'SinPermisos']);
        $role4=Role::create(['name'=>'Usuario General']);
        $role4=Role::create(['name'=>'Fisico Terapeuta']);
        $role4=Role::create(['name'=>'Dentista']);
        $role4=Role::create(['name'=>'Dermatologo']);
        $role4=Role::create(['name'=>'Medico Particular']);
        $role4=Role::create(['name'=>'Psicologo']);


        //Permission::create(['name'=>'admin.index'])->syncRoles([$role1,$role2]);



        Permission::create(['name'=>'admin.frontpage.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.frontpage.update'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.profile.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.profile.update'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.profile.avatar'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name'=>'admin.users.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'admin.tickets.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.dataprofileticket'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.edit'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.updateprofiledata'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.createsuggestion'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.storenewsuggestion'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.createcomplaint'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.storenewcomplaint'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'admin.tickets.destroy'])->syncRoles([$role1]);



        Permission::create(['name'=>'admin.skills.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.skills.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.skills.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.skills.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'admin.tasks.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.tasks.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.tasks.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.tasks.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'admin.customers.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.customers.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.customers.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.customers.destroy'])->syncRoles([$role1]);


        Permission::create(['name'=>'admin.materials.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.materials.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.materials.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.materials.destroy'])->syncRoles([$role1]);


        Permission::create(['name'=>'admin.employees.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.employees.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.employees.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.employees.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'admin.states.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.states.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.states.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.states.destroy'])->syncRoles([$role1]);


        Permission::create(['name'=>'admin.terms.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.terms.uploadpdf'])->syncRoles([$role1]);

        /*
        Permission::create(['name'=>'admin.contracts.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.contracts.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.contracts.store'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.contracts.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.contracts.update'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.contracts.destroy'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.contracts.stadistics'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'admin.tickets.getpay'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.tickets.maketicketpay'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.ticket.responsepay'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.calculaganancias'])->syncRoles([$role1,$role2]);
*/


        //presupuestos
        Permission::create(['name'=>'admin.budgets.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.store'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.budgets.update'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.budgets.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'admin.budgets.employees_tasks_update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.materials_update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.payments_update'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.budgets.print'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.budgets.tracing'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.createregtracing'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.tracingstore'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.tracingupdate'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.tracingedit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'admin.budgets.tracingdestroy'])->syncRoles([$role1]);
    }
}
