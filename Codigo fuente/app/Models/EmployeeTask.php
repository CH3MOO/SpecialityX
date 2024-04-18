<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
    use HasFactory;
    protected $fillable=[
        'employee_id',
        'task_id'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }
}
