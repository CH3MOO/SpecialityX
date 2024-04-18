<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'precio_hora',

    ];



    public function budgettaskemployee(){
        return $this->hasMany(budgettaskemployee::class);
    }
    public function budgettracings(){
        return $this->hasMany(budgettracing::class);
    }
    public function employetasks(){
        return $this->hasMany(EmployeeTask::class);
    }
}
