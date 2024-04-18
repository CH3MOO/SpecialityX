<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Style;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MaterialController extends Controller
{
    public function index()
    {
        $styles=Style::all();
        $materials=Material::all();
        return view('admin.materials.index',compact('styles','materials'));
        return view('admin.index');
    }

    public function create()
    {

        $styles=Style::all();
        return view('admin.materials.create',compact('styles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|unique:materials',
            'observaciones'=>'required',
            'precio_unitario'=>'required',

        ]);
        $material= Material::create($request->all());
        Alert::toast('El material se creo de forma exitosa', 'success');
        return redirect()->route('admin.materials.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Material $material)
    {
        $styles=Style::all();
        return view('admin.materials.edit',compact('styles','material'));
    }

    public function update(Material $material,Request $request)
    {
        $request->validate([
            'nombre'=>'required|unique:materials,nombre,'.$material->id,
            'observaciones'=>'required',
            'precio_unitario'=>'required',
        ]);

        $styles=Style::all();
        $material->update($request->all());//se actualizan los datos
        Alert::success('¡Listo!','El material se actualizó correctamente');
        return redirect()->route('admin.materials.edit',compact('material'));
    }

    public function destroy(Material $material)
    {

        $material->delete();
        Alert::success('¡Listo!',"El material se elimino correctamente");
        return redirect()->route('admin.materials.index');
    }
}
