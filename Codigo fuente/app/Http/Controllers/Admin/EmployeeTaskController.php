<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeTask;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeTaskController extends Controller
{
    public function updateTasks(Employee $employee, Request $request){


        $customMessages = [
            'tasks_id.required' => 'Debe agregar al menos una habilidad.',
        ];

        $request->validate([
            'tasks_id'=>'required'
        ],$customMessages);

        $tasks=EmployeeTask::where('employee_id',$employee->id)
                                            ->delete();
        foreach($request->tasks_id as $task){

            $result=EmployeeTask::create([
                'task_id'=>$task,
                'employee_id'=>$employee->id,
            ]);
        }
        Alert::success('¡Listo!', 'Se actualizarón las tareas del empleado');
        return redirect()->route('admin.employees.edit',compact('employee'));
    }
}
