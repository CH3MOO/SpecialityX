<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeSkill;
use App\Models\EmployeeTask;
use App\Models\Skill;
use App\Models\Style;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{

    public function index()
    {
        $styles=Style::all();
        $employees=Employee::all();
        return view('admin.employees.index',compact('styles','employees'));
    }

    public function create()
    {

        $styles=Style::all();
        return view('admin.employees.create',compact('styles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo'=>'required',
            'cedula'=>'required',
            'celular'=>'required',
            'fecha_nacimiento'=>'required',
            'telefono_alternativo'=>'required',
            'domicilio'=>'required',
            'uniforme'=>'required',

        ]);
        $employee= Employee::create($request->all());
        Alert::toast('El empleado se creó de forma exitosa', 'success');
        return redirect()->route('admin.employees.edit',compact('employee'));
    }


    public function show($id)
    {
        //
    }

    public function edit(Employee $employee)
    {
        $styles=Style::all();
        //$skills=Skill::all();
        $tasks=Task::all();
        //$includes=EmployeeSkill::where('employee_id',$employee->id)->get();
        $includes=EmployeeTask::where('employee_id',$employee->id)->get();
        return view('admin.employees.edit',compact('styles','employee','tasks','includes'));
    }


    public function update( Employee $employee,Request $request)
    {
        $request->validate([
            'nombre_completo'=>'required',
            'cedula'=>'required',
            'celular'=>'required',
            'fecha_nacimiento'=>'required',
            'telefono_alternativo'=>'required',
            'domicilio'=>'required',
            'uniforme'=>'required',
        ]);

        $styles=Style::all();
        $employee->update($request->all());//se actualizan los datos
        Alert::toast('El empleado se actualizó de forma exitosa', 'success');
        //Alert::success('El empleado se actualizó de forma exitosa');
        return redirect()->route('admin.employees.edit',compact('employee'));
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        Alert::success('¡Listo!',"El empleado se elimino correctamente");
        return redirect()->route('admin.employees.index');
    }
}
