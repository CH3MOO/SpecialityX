<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetTaskEmployee extends Model
{
    use HasFactory;
    protected $fillable=[
        'budget_id',
        'task_id',
        'fecha',
        'desde',
        'hasta',
        'descanso',
        'extra',
        'nocturnidad',
        'cantidad',
        'total'
    ];


    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }




}
