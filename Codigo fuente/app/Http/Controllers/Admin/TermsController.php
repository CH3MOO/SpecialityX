<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Style;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function index(){
        $styles=Style::all();
        $title="Terminos y Condiciones";
        $show_buttons=false;
        $name_file=$this->getNameFile();
        $name_file=($this->getNameFile()!="")?$this->getNameFile():"Aun no se ha subido un archivo";
        return view('admin.terms.index',compact('styles','title','show_buttons'));

    }
    public function uploadPdf(Request $request){
        $request->validate([
           "pdf_file"=>'required|max:2048',
        ]
     );

     $this->deleteFiles();
     $pdf = $request->file("pdf_file");
     $name=$pdf->getClientOriginalName();
     $ruta = public_path("terms/");
     copy($pdf->getRealPath(),$ruta.$name);
     return redirect()->route('admin.terms.index')->with('info','El archivo se actualizó de forma correcta');
    }

    public function downloadpdf(){
        if($this->getNameFile()==""){//no existe el archivo de terminos y condiciones
            return redirect()->route('home')->with('error',"Lo siento, no hay un archivo de terminos y condiciones");
        }
        else{
            return response()->download("terms/".$this->getNameFile());//existe archivo de terminos y condiciones
        }
    }


    private function getNameFile(){
        $folder = "terms/";
        $name_file="";
        if ($handler = opendir($folder)) {
            while (false !== ($file = readdir($handler))) {
                    $name_file=$file;

            }
            closedir($handler);
        }
        return ($name_file=="..")?"":$name_file;
        //return $name_file;
    }

    private function deleteFiles(){
        $files = glob('terms/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }

    }
}
