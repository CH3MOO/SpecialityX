<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Style;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $styles=Style::all();
        $customers=Customer::all();
        return view('admin.customers.index',compact('customers','styles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $styles=Style::all();
        return view('admin.customers.create',compact('styles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
            'razon_social'=>'required',
            'rut'=>'required',
            'direccion'=>'required',
            'telefono'=>'required'

        ]);


        $customer= Customer::create($request->all());
        Alert::toast('El paciente se creo de forma exitosa', 'success');
        return redirect()->route('admin.customers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Customer $customer)
    {
        $styles=Style::all();
        return view('admin.customers.edit',compact('styles','customer'));
    }

    public function update(Customer $customer, Request $request)
    {
        $request->validate([
            'rut'=>'required|unique:customers,rut,'.$customer->id,//el nombre puede ser el mismo
            'nombre'=>'required',
            'razon_social'=>'required',
            'direccion'=>'required',
            'telefono'=>'required'
        ]);

        $styles=Style::all();
        $customer->update($request->all());//se actualizan los datos
        Alert::success('¡Listo!','El paciente se actualizó correctamente');
        return redirect()->route('admin.customers.edit',compact('customer'));

    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        Alert::success('¡Listo!',"El paciente se elimino correctamente");
        return redirect()->route('admin.customers.index');
    }
}
