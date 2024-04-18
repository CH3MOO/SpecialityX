<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
        return redirect()->route('admin.index');
    }

    public function landing(){

        return view('welcome');
    }

    public function contact(Request $request)
    {
        $data=Array(
            'subject'=>'Una persona busca contactar',
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
            'email'=>$request->email,
            'message'=>$request->message,
        );



        $mail=new ContactMail($data);
        Mail::to('noreply@correo.com.mx')->send($mail);
        Alert::toast('¡Listo!, Su correo se envió, pronto será contactado. ','success');
        return redirect()->route('welcome');
    }
}
