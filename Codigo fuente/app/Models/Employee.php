<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre_completo',
        'cedula',
        'celular',
        'fecha_nacimiento',
        'domicilio',
        'telefono_alternativo',
        'uniforme',
        'otros'

    ];

    protected $append=['skill'];



    public function getSkillAttribute()
    {


        $skills=EmployeeTask::select(DB::raw("GROUP_CONCAT(task_id SEPARATOR ',') as sks"))
            ->where('employee_id',$this->id)
            ->get();
        $skills=EmployeeTask::select('task_id')
            ->where('employee_id',$this->id)
            ->get()
            ->toArray();



        $skill_names=Skill::select(DB::raw("GROUP_CONCAT(nombre SEPARATOR ',') as sks"))
                            ->whereIn('id',$skills)->get();

        return $skill_names;

    }

    public function employeeskils(){
        return $this->hasMany(EmployeeSkill::class);
    }

    public function budgetemployeees(){
        return $this->hasMany(BudgetEmployee::class);
    }
    public function budgettracings(){
        return $this->hasMany(BudgetTracing::class);
    }
}
