<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetState;
use App\Models\State;
use App\Models\Style;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StateController extends Controller
{
    public function index()
    {
        $styles=Style::all();
        $states=State::all();
        return view('admin.states.index',compact('styles','states'));
    }

    public function create()
    {
        $styles=Style::all();
        return view('admin.states.create',compact('styles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|unique:states',
            'descripcion'=>'required'

        ]);


        $budgetstate= State::create($request->all());
        Alert::toast('El estado de presupuesto se creo de forma exitosa', 'success');
        return redirect()->route('admin.states.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(State $state)
    {
        $styles=Style::all();
        return view('admin.states.edit',compact('styles','state'));
    }

    public function update(State $state, Request $request)
    {

        $request->validate([
            'nombre'=>'required|unique:states,nombre,'.$state->id,//el nombre puede ser el mismo
            'descripcion'=>'required'
        ]);
        $styles=Style::all();
        $state->update($request->all());//se actualizan los datos
        Alert::success('¡Listo!','El estado se actualizó correctamente');
        return redirect()->route('admin.states.edit',compact('state'));
    }

    public function destroy(State $state)
    {
        $state->delete();
        Alert::success('¡Listo!',"El estado se elimino correctamente");
        return redirect()->route('admin.states.index');
    }
}
