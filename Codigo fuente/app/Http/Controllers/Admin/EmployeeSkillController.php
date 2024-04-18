<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeSkill;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeSkillController extends Controller
{
    public function index()
    {
        return view('admin.employeeskills.index');

    }


    public function updateSkills(Employee $employee, Request $request){

        $customMessages = [
            'skills_id.required' => 'Debe agregar al menos una habilidad.',
        ];

        $request->validate([
            'skills_id'=>'required'
        ],$customMessages);

        $skills=EmployeeSkill::where('employee_id',$employee->id)
                                            ->delete();
        foreach($request->skills_id as $skill){

            $result=EmployeeSkill::create([
                'skill_id'=>$skill,
                'employee_id'=>$employee->id,
            ]);
        }
        Alert::success('¡Listo!', 'Se actualizarón las habilidades del empleado');
        return redirect()->route('admin.employees.edit',compact('employee'));
    }
}
