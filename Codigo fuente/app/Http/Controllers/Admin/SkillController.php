<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Style;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SkillController extends Controller
{
    public function index()
    {
        $styles=Style::all();
        $skills=Skill::all();
        return view('admin.skills.index',compact('styles','skills'));
    }

    public function create()
    {
        $styles=Style::all();
        return view('admin.skills.create',compact('styles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required'

        ]);


        $skill= Skill::create($request->all());
        Alert::toast('La habilidada se creo de forma exitosa', 'success');
        return redirect()->route('admin.skills.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Skill $skill)
    {
        $styles=Style::all();
        return view('admin.skills.edit',compact('styles','skill'));
    }

    public function update(Skill $skill, Request $request)
    {

        $request->validate([
            'nombre'=>'required|unique:skills,nombre,'.$skill->id,//el nombre puede ser el mismo
        ]);
        $styles=Style::all();
        $skill->update($request->all());//se actualizan los datos
        Alert::success('¡Listo!','La tarea se actualizó correctamente');
        return redirect()->route('admin.skills.edit',compact('skill'));
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        Alert::success('¡Listo!',"La tarea se elimino correctamente");
        return redirect()->route('admin.skills.index');
    }
}
