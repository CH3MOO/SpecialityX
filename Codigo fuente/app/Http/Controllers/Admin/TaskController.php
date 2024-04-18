<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Style;
use App\Models\Task;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TaskController extends Controller
{
    public function index()
    {
        $styles=Style ::all();
        $tasks=Task::all();
        return view('admin.tasks.index',compact('styles','tasks'));
    }

    public function create()
    {

        $styles=Style::all();
        return view('admin.tasks.create',compact('styles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|unique:tasks',
            'precio_hora'=>'required',
        ]);
        $task= Task::create($request->all());
        Alert::toast('La tarea se creo de forma exitosa', 'success');
        return redirect()->route('admin.tasks.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Task $task,Request $request)
    {

        $styles=Style::all();
        return view('admin.tasks.edit',compact('styles','task'));
    }

    public function update(Task $task,Request $request)
    {

        $request->validate([
            'nombre'=>'required|unique:tasks,nombre,'.$task->id,
            'precio_hora'=>'required',
        ]);

        $styles=Style::all();
        $task->update($request->all());//se actualizan los datos
        Alert::success('¡Listo!','La tarea se actualizó correctamente');
        return redirect()->route('admin.tasks.edit',compact('task'));

    }

    public function destroy(Task $task)
    {
        $task->delete();
        Alert::success('¡Listo!',"La tarea se elimino correctamente");
        return redirect()->route('admin.tasks.index');
    }
}
