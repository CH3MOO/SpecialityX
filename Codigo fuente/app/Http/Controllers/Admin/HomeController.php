<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontPage;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function index(){

        $frontpage=FrontPage::where('id',1)->first();
        $styles=Style::all();

        return view('admin.index',compact('frontpage','styles'));
    }

    public function frontPage(){
        $styles=Style::all();
        $frontpage=FrontPage::where('id',1)->first();
        return view('admin.frontpage.index',compact('styles','frontpage'));
    }

    public function frontPageUpdate(FrontPage $frontpage, Request $request)
    {


        $rules=[
            'title'=>'required',
            'description'=>'required',
            'bg_color'=>'required'
        ];

        $messages=[
            'title.required'=>'Ingrese un titulo',
            'description.required'=>'Coloque una descripción',
            'bg_color.required'=>'Debe indicar un color de titulos'
        ];

        $data=$request->all();
        $validator=Validator::make($data,$rules,$messages);

        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {


            if($request->hasFile('picture'))
            {

                $picture=$request->file('picture');
                $file_name=time().'.'.$picture->getClientOriginalExtension();
                $image=Image::make($picture);
                //$image->resize(300,300);
                $image->save(public_path('storage/frontpage/'.$file_name));

                
                //$frontpage=FrontPage::where('id',1)->first();
                $frontpage->update([
                        'picture'=>'storage/frontpage/'.$file_name
                ]);


            }

            $frontpage->update([
                'title'=>$request->title,
                'description'=>$request->description,
            ]);
            $style=Style::where('property','bg_color')->first();
            $style->update([
                'value'=>$request->bg_color,
            ]);
            Alert::success('¡Listo!',"La configuración se actualizó");
            return redirect()->route('admin.frontpage.index');
        }
    }
}
