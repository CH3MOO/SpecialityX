<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Style;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\AuthRouteMethods;
use RealRashid\SweetAlert\Facades\Alert;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.tickets.index')->only('index');
        $this->middleware('can:admin.tickets.create')->only('create','store');
        $this->middleware('can:admin.tickets.edit')->only('edit','update');
        $this->middleware('can:admin.tickets.destroy')->only('destroy');
    }


    public function index()
    {

        $tickets=(Auth::user()->roles->first()->name=="Administrador"?Ticket::all():Ticket::where('user_id',Auth::user()->id)->get());

        $styles=Style::all();
        return view('admin.ticket.index',compact('styles','tickets'));
    }

    public function getPay(Contract $contract)
    {
        $styles=Style::all();
        return view('admin.ticket.getpay', compact('styles','contract'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(Ticket $ticket)
    {

        $this->authorize('authorTicket',$ticket);

        $user=User::where('id',$ticket->user_id)->first();
        $styles=Style::all();

        switch($ticket->ticket_type_id){
            case '1'://sugerencia
                    return view('admin.ticket.edit_suggestion',compact('styles','ticket'));
                    break;
            case '2'://queja

                    return view('admin.ticket.edit_complaint',compact('styles','ticket'));
                    break;
            case '3'://cambio de datos

                    $new_data=Array();

                    if($ticket->country!=null){
                        array_push($new_data,['name'=>'country','description'=>'País']);
                    }


                    if($ticket->state!=null){
                        array_push($new_data,['name'=>'state','description'=>'Estado']);
                    }

                    if($ticket->city!=null){
                        array_push($new_data,['name'=>'city','description'=>'Ciudad']);
                    }

                    if($ticket->wallet!=null){
                        array_push($new_data,['name'=>'wallet','description'=>'Billera']);
                    }

                    if($ticket->identity_document_name!=null){
                        array_push($new_data,['name'=>'identity_document_name','description'=>'Documento de indentidad']);
                    }

                    if($ticket->identity_document_number!=null){
                        array_push($new_data,['name'=>'identity_document_number','description'=>'Número de documento de identidad']);
                    }

                    if($ticket->phone_number!=null){
                        array_push($new_data,['name'=>'phone_number','description'=>'Teléfono']);
                    }

                    if($ticket->email!=null){
                        array_push($new_data,['name'=>'email','description'=>'Correo']);
                    }

                    return view('admin.ticket.change_data',compact('styles','user','ticket','new_data'));
                    break;
            case '4'://retiro, desde aqui se debe autorizar
                    $contract=Contract::where('id',$ticket->contract_id)->first();


                    if(Auth::user()->roles->first()->name=="Administrador"){//si el creador es el admin
                        return view('admin.ticket.responseticketpay',compact('styles','ticket','contract'));
                    }
                    else{
                        return view('admin.ticket.responseticketpay_viewuser',compact('styles','ticket','contract'));
                    }


                    break;

            default:
                    return "default";
                    break;

        }

    }

    public function update(Ticket $ticket,Request $request)
    {


        $data=$request->all();
        $rules=[
                    'answer'=>['required'],
                    //'status'=>['required']

                ];
        $messages=[
                    'answer.required'=>'Dede colocar un mensaje de respuesta al usuario para poder continuar',
                    //'status.required'=>'Debe seleccionar un estado para el ticket'
                    ];

        $validator=Validator::make($data,$rules,$messages);

        if($validator->fails())
        {

            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {


                //validar si el tickes es retiro de ganacias u otro
            /*
            if($ticket->ticket_type_id==4)//retiro
            {
                return "primera validacion";
                $new_payment=Payment::create([
                    'contract_id'=>$ticket->contract_id,
                    'amount'=>$request->amount,
                    'payment_date'=>Carbon::now()
                ]);

                $contract=Contract::where('id',$ticket->contract_id)->first();
                //ajustar total de retiros en contrato
                $contract->update(
                            [
                                'total_payments'=>$contract->total_payments + $new_payment->amount
                            ]
                    );
                //enviar correo de notificación
                Alert::toast('El retiro ha sido aprobado con éxito','success');
            }
            else
            {
                //enviar correo de notificación
                Alert::toast('El ticket se marco como cerrado','success');
            }
            */

            $ticket->update([
                'answer'=>$request->answer,
                'status'=>1,//cerrado
                'close_date'=>Carbon::now(),
            ]);
            Alert::toast('¡Listo!,El ticket se cerro de forma correcta','success');
            //enviar notificación de ticket atendido
            return redirect()->route('admin.tickets.index');
        }
    }


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        Alert::toast('¡Listo!, El ticket se eliminó de forma correcta','success');
        return redirect()->route('admin.tickets.index');

    }



    public function dataProfileTicket(User $user, Request $request){
        if($request->exists('country')||$request->exists('state')||$request->exists('city')||$request->exists('identity_document_name')||$request->exists('identity_document_number')||$request->exists('wallet')||$request->exists('phone_number')||$request->exists('email')){
            $request->merge([
                'user_id'=>Auth::user()->id,
                'description'=>'Solicito cambio de datos',
                'ticket_type_id'=>'3',
                'status'=>0,
            ]);
            $new_ticket=Ticket::create($request->all());
            Alert::toast('Su solicitud  de cambio se envió', 'success','top-right');

        }
        else
        {
            Alert::toast('Nada que cambiar', 'info','top-right');
        }
        return redirect()->route('admin.profile.index');
    }

    public function updateProfileData(Ticket $ticket, Request $request){

        $update_data=Array();
        $user=User::where('id',$ticket->user_id)->first();

        if($request->exists('country')){
            $request->merge(['country_old'=>$user->country]);
            $update_data['country']=$request->country;
        }


        if($request->exists('state')){
            $request->merge(['state_old'=>$user->state]);
            $update_data['state']=$request->state;
        }

        if($request->exists('city')){
            $request->merge(['state_city'=>$user->city]);
            $update_data['city']=$request->city;
        }

        if($request->exists('identity_document_name')){
            $request->merge(['identity_document_name_old'=>$user->identity_document_name]);
            $update_data['identity_document_name']=$request->identity_document_name;
        }

        if($request->exists('identity_document_number')){
            $request->merge(['identity_document_number_old'=>$user->identity_document_number]);
            $update_data['identity_document_number']=$request->identity_document_number;
        }

        if($request->exists('wallet')){
            $request->merge(['wallet_old'=>$user->wallet]);
            $update_data['wallet']=$request->wallet;
        }

        if($request->exists('phone_number')){
            $request->merge(['phone_number_old'=>$user->phone_number]);
            $update_data['phone_number']=$request->phone_number;
        }
        if($request->exists('email')){
            $request->merge(['email_old'=>$user->email]);
            $update_data['email']=$request->email;
        }



        $user->update($update_data);
        $request->merge([
            'status'=>1,
            'close_date'=>Carbon::now()
        ]);

        $ticket->update($request->all());
        Alert::toast('Los cambios fueron aplicados', 'success');


        return redirect()->route('admin.tickets.index');

    }


    public function createSuggestion()
    {
        $styles=Style::all();
        return view('admin.ticket.new_suggestion',compact('styles'));
    }


    public function createComplaint(){
        $styles=Style::all();
        return view('admin.ticket.new_complaint',compact('styles'));
    }


    public function storeSuggestion(Request $request){
        $data=$request->all();
        $rules=[
            'message'=>[
                                'required'
            ]
        ];
        $messages=[
            'message.required'=>'Debe colocar un mensaje para continuar'
        ];

        $validator=Validator::make($data,$rules,$messages);

        if($validator->fails()){

            return redirect()->route('admin.tickets.createsuggestion')
                            ->withInput()
                            ->withErrors($validator);
        }
        else{
            $ticket=Ticket::create([
                'user_id'=>Auth::user()->id,
                'description'=>$request->message,
                'ticket_type_id'=>'1',//sugerencia
                'status'=>0,//abierto

            ]);

            Alert::toast('La sugerencia fue enviada','success');
            return redirect()->route('admin.tickets.index');
        }
    }

    public function storeComplaint(Request $request){

        $data=$request->all();
        $rules=[
            'message'=>[
                                'required'
            ]
        ];
        $messages=[
            'message.required'=>'Debe colocar un mensaje para continuar'
        ];

        $validator=Validator::make($data,$rules,$messages);

        if($validator->fails()){

            return redirect()->route('admin.tickets.createcomplaint')
                            ->withInput()
                            ->withErrors($validator);
        }
        else{

            $ticket=Ticket::create([
                'user_id'=>Auth::user()->id,
                'description'=>$request->message,
                'ticket_type_id'=>'2',//queja
                'status'=>0,//abierto

            ]);

            Alert::toast('Su queja fue enviada','success');
            return redirect()->route('admin.tickets.index');
        }
    }

    public function makeTicketPay(Contract $contract, Request $request)
    {

        $request->validate([
            'qty'=>'required',
            'message'=>'required'
        ]);


        if(($contract->total_gain<50)||(($contract->total_gain - $contract->total_payments)  < $request->qty))
        {

            if($contract->total_gain<50)//el retiro minimo permitido
            {
                Alert::error('No puede retirar, debe contar con almenos 50 usd de ganancía');
            }

            if($contract->total_gain<$request->qty)
            {
                Alert::error('El importe de retiro debe ser menor o igual al total de ganancias');
            }


            return redirect()->route('admin.contracts.index');

        }

        $retiro=Ticket::create([
            'user_id'=>$contract->user_id,
            'contract_id'=>$contract->id,
            'description'=>$request->message,
            'amount'=>$request->qty,
            'answer'=>"Tu ticket será atendido en breve",
            'ticket_type_id'=>4,//retiro
            'status'=>0,//ticket abierto
        ]);

        Alert::success('¡Listo!', 'Su solicitud de retiro se envio de forma adecuada');
        return redirect()->route('admin.tickets.index');
    }

    public function responsePay(Ticket $ticket, Request $request)
    {
        $request->validate([
            'answer'=>'required',
            'authorize'=>'required',
        ]);

        $contract=Contract::where('id',$ticket->contract_id)->first();
        if($request->authorize==1 && $ticket->status==0){//se libera el pago
            if( ($contract->total_gain - $contract->total_payments) < $ticket->amount)//saldo insuficiente
            {

                Alert::toast('¡ops!, El saldo es insuficiente, se cerro el ticket','error');
                $ticket->update([
                    'status'=>1,//cerrado
                    'approved'=>0,//no aprovado por saldo insuficiente
                    'answer'=>$request->answer,
                    'close_date'=>now()
                ]);
            }
            else
            {
                $new_payment=Payment::create(
                    [
                        'contract_id'=>$ticket->contract_id,
                        'amount'=>$ticket->amount,
                        'payment_date'=>Carbon::now(),
                        'message'=>'Se realizó un pago por: '.$ticket->amount,
                    ]);


                $all_payments=Payment::where('contract_id',$ticket->contract_id)
                                        ->get();


                $total_payments=0;
                foreach($all_payments as $payment){
                    $total_payments=$total_payments+ $payment->amount;
                }

                $contract->update([
                    'total_payments'=>$total_payments,
                ]);

                Alert::toast('¡Listo!, El retiro fue aprobado,se marco el ticket como cerradado','success');
                $ticket->update([
                    'status'=>1,//cerrado
                    'approved'=>1,//aprobado
                    'answer'=>$request->answer,
                    'close_date'=>now()
                ]);
            }
        }
        else
        {
            Alert::toast('¡Listo!, El retiro fue negado,se cerro el ticket','success');
            $ticket->update([
                'status'=>1,//cerrado
                'approved'=>0,//no aprobado
                'answer'=>$request->answer,
                'close_date'=>now()
            ]);
        }


        return redirect()->route('admin.tickets.index');
    }
}
