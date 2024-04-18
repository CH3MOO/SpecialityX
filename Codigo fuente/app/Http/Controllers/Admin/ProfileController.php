<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Style;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function index(){

        $user = auth()->user();




        $styles=Style::all();
        return view('admin.profile.index',compact('styles','user'));


    }

    public function update(User $user, Request $request){
        //llegan los parametros para hacer los ajustes

        $request->validate([
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'identity_document_name'=>'required',
            'identity_document_number'=>'required',
            'email'=>'required',

        ]);

        $user->update([
            'country'=>$request->country,
            'state'=>$request->state,
            'city'=>$request->city,
            'identity_document_name'=>$request->identity_document_name,
            'identity_document_number'=>$request->identity_document_number,
            'email'=>$request->email,
        ]);

        Alert::toast('Los datos han sido actualizados','success');
        return redirect()->route('admin.profile.index',compact('user'));


    }

    public function avatar(Request $request){
        $styles=Style::all();
        if($request->hasFile('avatar'))
        {
            $user=($request->user_id!=null?User::where('id', $request->user_id)->first():Auth::user());
            $avatar=$request->file('avatar');
            $file_name=time().'.'.$avatar->getClientOriginalExtension();
            $image=Image::make($avatar);
            $image->resize(300,300);

            //Storage::disk('local')->put('avatars/'.$nombre_carpeta.'/'.$importado->rfc.'.xml',$xmlstr->saveXML());



            $image->save(storage_path('app/public/avatars/'.$file_name));
            //$image->save(public_path('uploads/avatars/'.$file_name));
            $user->avatar=$file_name;
            $user->save();






            if($user->id!=Auth::user()->id)
            {
                Alert::toast('Avatar cambiado correctamente','success');
                return redirect()->route('admin.users.edit',compact('styles','parent_code','user'));
            }
            else
            {
                return view('admin.profile.index',compact('styles','user'));
            }
        }
        else//si no hay cambio sólo regresa a la vista previa
        {
            return redirect()->back();
        }
    }
}


