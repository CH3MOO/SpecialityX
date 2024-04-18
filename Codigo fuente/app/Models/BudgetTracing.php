<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetTracing extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'budget_id',
        'employee_id',
        //'task_id',
        'fecha',
        'desde',
        'hasta',
        'asistencia',
        'jornal',
        'pago',
        'otros'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }
    /*
    public function task(){
        return $this->belongsTo(Task::class);
    }
    */
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
