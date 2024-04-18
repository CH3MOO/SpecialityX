<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{
    use HasFactory;
    protected $fillable=[
        'employee_id',
        'skill_id'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function skill(){
        return $this->belongsTo(Skill::class);
    }


    public function items()
    {
        return $this->hasMany(EmployeeSkill::class, 'employee_id');
    }

    // recursive relationship
    public function childItems()
    {
        return $this->hasMany(EmployeeSkill::class, 'employee_id')->with('items');
    }

}
