<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Style;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.create')->only('creat','store');
        $this->middleware('can:admin.users.edit')->only('edit','update');
        $this->middleware('can:admin.users.destroy')->only('destroy');
    }
//probando controller
    public function index()
    {
        $styles=Style::all();
        if(Auth::user()->roles->first()->name=="Admin"){

            $users=User::all();
        }
        else{

            $top_users = User::whereHas('roles', function($q){
                             $q->whereIn('name', ['Admin','Subadmin']);
                            })
                            ->get('id')
                            ->toArray();

            $users=User::whereNotIn('id',$top_users)->get();


        }
        foreach($users as $user){
            $user->role=$user->getRoleNames()->first();
        }

        return view('admin.users.index', compact('styles','users'));
    }


    public function create()
    {
        $styles=Style::all();

        if(Auth::user()->roles->first()->name!='Administrador'){

            $lst_roles=Role::whereNotIn('name',['Administrador','Subadmin'])
                            ->get()
                            ->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)->pluck('name','id');
        }
        else{
            $lst_roles=Role::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('name','id');
        }

        return view('admin.users.create', compact('styles','lst_roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|unique:users',//el campo email no debe repetirse
            'password'=>'required|min:8'
        ]);

        $sponsor_code= strtoupper(str_replace(' ','',str_replace(':','',str_replace('-','',Str ::random(5).Carbon::now()))));
        $request->merge(
                [
                    'sponsor_code'=>$sponsor_code,
                    'password'=>bcrypt($request->password)
                ]
            );

        $user= User::create($request->all());
        $user->roles()->sync($request->role);//se asignan los roles marcados
        $user->sendEmailVerificationNotification();//se envia correo de verificación

        Alert::toast('El usuario se creo de forma exitosa, se ha enviado un correo de verificación', 'success');
        return redirect()->route('admin.users.index');

    }

    public function show($id)
    {
        //
    }


    public function edit(User $user)
    {
        $styles=Style::all();
        $lst_roles=Role::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('name','id');




        $lst_roles->prepend('Sin rol',0);




        $role=$user->getRoleNames();
        $role_id=null;
        if(sizeof($role)>0){
            $role_id=$user->roles[0]->id;
        }

        return view('admin.users.edit',compact('styles','role_id','lst_roles','user'));
    }


    public function update(Request $request, User $user)
    {

        $request->validate([
            'email'=>'required|unique:users,email,'.$user->id,//el email no puede repetirse
        ]);
        $old_email=$user->email;
        $user->update($request->all());//se actualizan los datos
        $user->roles()->sync($request->role);//se asignan los roles marcados
        if($old_email!=$user->email)//El correo cambio, enviar correo de verificaciòn
        {
            $user->sendEmailVerificationNotification();//se envia correo de verificación
            Alert::toast('¡Datos actualizados!, se envió un link para verificar correo','info');
        }
        else
        {
            Alert::toast('Datos actualizados correctamente','success');
        }

        return redirect()->route('admin.users.edit',compact('user'));
    }


    public function destroy(User $user)
    {


        $name=$user->name;
        $id_user=$user->id;
        $user->delete();
        return redirect()->route('admin.users.index')->with('info','El usuario '. $name.' con id: '.$id_user.' se eliminó con éxito');



    }
}
