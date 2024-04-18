<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\BudgetEmployee;
use App\Models\BudgetMaterial;
use App\Models\BudgetPayment;
use App\Models\BudgetState;
use App\Models\BudgetTaskEmployee;
use App\Models\BudgetTracing;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Material;
use App\Models\State;
use App\Models\Style;
use App\Models\Task;
use App\Models\User;
//use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;

//$pdf = Pdf::loadView('pdf.invoice', $data);
//return $pdf->download('invoice.pdf');

use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.budgets.index')->only('index');
        $this->middleware('can:admin.budgets.create')->only('create','store');
        $this->middleware('can:admin.budgets.edit')->only('edit','update');
        $this->middleware('can:admin.budgets.destroy')->only('destroy');
    }

    public function index()
    {
        $styles=Style::all();
        $budgets=Budget::all();
        return view('admin.budgets.index',compact('styles','budgets'));
    }

    public function create()
    {
        $styles=Style::all();
        $customers=Customer::all();
        $lst_states=State::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('nombre','id');
        return view('admin.budgets.create',compact('styles','customers','lst_states'));
    }

    public function store(Request $request)
    {
        //return "aqui llega";
        $request->validate([
            'fecha'=>'required',
            'descripcion'=>'required',
            'locacion'=>'required',
            'customer_id'=>'required',
        ]);

        $request->merge([
            'state_id'=>1,
            //'fecha'=>Carbon::now(),
        ]);

        $budget=Budget::create($request->all());

        Alert::toast('El presupuesto se creo de forma exitosa', 'success');
        return redirect()->route('admin.budgets.edit',compact('budget'));
        //return redirect()->route('asmin.budgets.edit',compact('budget'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Budget $budget)
    {
        $styles=Style::all();
        $customers=Customer::all();
        $includes=BudgetTaskEmployee::where('budget_id',$budget->id)->get();
        $material_includes=BudgetMaterial::where('budget_id',$budget->id)->get();
        $payment_includes=BudgetPayment::where('budget_id',$budget->id)->get();

        $lst_states=State::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('nombre','id');
        $employees=Employee::all();
        $tasks_list=Task::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('nombre','id');
        $tasks=Task::all();
        $materials_list=Material::all()->sortBy('name',SORT_NATURAL| SORT_FLAG_CASE)->pluck('nombre','id');
        $materials=Material::all();


        $hours=[
            1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'10',10=>'11',11=>'12',12=>'13',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20',21=>'21',22=>'22',23=>'23',24=>'24'
        ];
        $optionAttributesStart=[];
        $optionAttributesEnd=[];

        for($i=0;$i<count($hours);$i++){
            $optionAttributesStart[$i]=[
                'id'=>'',
                'class'=>'start',
            ];
        }
        for($i=0;$i<count($hours);$i++){
            $optionAttributesEnd[$i]=[
                'id'=>'',
                'class'=>'end',
            ];
        }


        $optionAttributes = [];
        foreach ($tasks as $task) {
            $optionAttributes[$task->id] = [
                'id'            =>'Seaginnaenlavew',
                'data-costh' => $task->precio_hora,
                'class'=>'option'
            ];
        }

        $materialAttributes=[];
        foreach($materials as $material){
            $materialAttributes[$material->id]=[
                'id'=>'',
                'data-costu'=>$material->precio_unitario,
                'class'=>'option-material'
            ];
        }

        return view('admin.budgets.edit',compact('hours',
                                                    'budget',
                                                    'styles',
                                                    'customers',
                                                    'lst_states',
                                                    'includes',
                                                    'material_includes',
                                                    'payment_includes',
                                                    'tasks',
                                                    'tasks_list',
                                                    'materials',
                                                    'materials_list',
                                                    'optionAttributes',
                                                    'optionAttributesStart',
                                                    'optionAttributesEnd',
                                                    'materialAttributes'
                                                ));
    }

    public function update(Budget $budget,Request $request)
    {

        $request->validate([
            'fecha'=>'required',
            'customer_id'=>'required',
            'state_id'=>'required',
            'descripcion'=>'required',
            'locacion'=>'required',

        ]);

        $now=Carbon::now();
        /*
        $request->merge([
            'fecha'=>now()
        ]);
        */
        $budget->update($request->all());
        Alert::toast('¡El presupuesto se actualizó de forma correcta!','success');
        return redirect()->route('admin.budgets.edit',compact('budget'));
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        Alert::toast('¡El presuspuesto y todos sus datos se eliminaron!','success');
        return redirect()->route('admin.budgets.index');
    }



    public function printPDF(Budget $budget)
    {

        $users = User::get();
        //$tasks=BudgetTaskEmployee::all();
        $tasks=BudgetTaskEmployee::where('budget_id',$budget->id)->get();
        $materials=BudgetMaterial::where('budget_id',$budget->id)->get();
        $payments=BudgetPayment::where('budget_id',$budget->id)->get();



        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'users' => $users,
            'budget'=>$budget,
            'tasks'=>$tasks,
            'materials'=>$materials,
            'payments'=>$payments
        ];


        $pdf = PDF::loadView('admin.pdfs.budgets.mypdf', $data);
        //$pdf->setPaper('A4', 'landscape');//set page size and orientation
        $pdf->setPaper('A4');//set page size and orientation
        $pdf->render();////Render the HTML as PDF
        return $pdf->stream();
        //return $pdf->download('itsolutionstuff.pdf');

        //return $budget;
    }

    public function employeesTasksUpdate(Budget $budget,Request $request)
    {
        if(!empty($request->input('fecha')))
        {
            $request->validate([
                'fecha'=>'required',
                'start'=>'required',
                'end'=>'required',
                'tasks'=>'required',
                'pause'=>'required',
                'xtra'=>'required',
                'night'=>'required',
                'qty'=>'required',
                'costh'=>'required',
                'total'=>'required'
            ]);
            $delete=BudgetTaskEmployee::where('budget_id',$budget->id)->delete();
            $size=count($request->start);
                for($i=0;$i<$size;$i++){
                    $rhhtask= BudgetTaskEmployee::create([
                        'budget_id'=>$budget->id,
                        'task_id'=>$request->tasks[$i],
                        'fecha'=>$request->fecha[$i],
                        'desde'=>$request->start[$i],
                        'hasta'=>$request->end[$i],
                        'descanso'=>$request->pause[$i],
                        'extra'=>$request->xtra[$i],
                        'nocturnidad'=>$request->night[$i],
                        'cantidad'=>$request->qty[$i],
                        'total'=>$request->total[$i],
                    ]);
                }

            $total_rh=array_sum($request->total);
            $budget->update([
                'total'=>$total_rh+$budget->total_materiales,
                'total_rh'=>$total_rh
                ]);
        }
        else
        {
            $delete=BudgetTaskEmployee::where('budget_id',$budget->id)->delete();
            $budget->update([
                'total'=>$budget->total_materiales,
                'total_rh'=>0
                ]);
        }
        Alert::toast('Listo, el presupuesto se edito!','success');
        return redirect()->route('admin.budgets.edit',compact('budget'));
    }



    public function materialsUpdate(Budget $budget, Request $request)
    {

        $request->validate([
            'materials'=>'required',
            'qty'=>'required',
            'costu'=>'required',
            'total'=>'required',
            'ppromo'=>'required',

        ]);

        $delete=BudgetMaterial::where('budget_id',$budget->id)->delete();
        $size=count($request->materials);

        for($i=0;$i<$size;$i++){
            $material= BudgetMaterial::create([
                'budget_id'=>$budget->id,
                'material_id'=>$request->materials[$i],
                'cantidad'=>$request->qty[$i],
                'precio_promo'=>$request->ppromo[$i],
                'total'=>$request->total[$i],
            ]);

        }

        $total_materiales=array_sum($request->total);
        $budget->update([
            'total'=>$budget->total_rh+$total_materiales,
            'total_materiales'=>$total_materiales
            ]);

        Alert::toast('Listo, los materiales del presupuesto se guardaron!','success');
        return redirect()->route('admin.budgets.edit',compact('budget'));

    }


    public function paymentsUpdate(Budget $budget,Request $request)
    {
        if(!empty($request->input('payment_date')))
        {

            $request->validate([
                'payment_date'=>'required',
                'amount'=>'required',
                'comment'=>'required',
            ]);

            $delete=BudgetPayment::where('budget_id',$budget->id)->delete();

                $size=count($request->payment_date);
                    for($i=0;$i<$size;$i++){
                        $payment= BudgetPayment::create([
                            'budget_id'=>$budget->id,
                            'fecha'=>$request->payment_date[$i],
                            'monto_pago'=>$request->amount[$i],
                            'observaciones'=>$request->comment[$i]
                        ]);
                    }

                $total_payment=array_sum($request->amount);
                $budget->update([
                    'pagos'=>$total_payment
                    ]);
        }
        else
        {
            $delete=BudgetPayment::where('budget_id',$budget->id)->delete();
            $budget->update([
                'pagos'=>0,
                ]);
        }
        Alert::toast('Listo, el presupuesto se edito!','success');
        return redirect()->route('admin.budgets.edit',compact('budget'));






    }

    public function tracingBudget(Budget $budget)
    {
        //return $budget;

        $styles=Style::all();
        //$tracings=BudgetTracing::where('budget_id',$budget->id);
        $tracings=BudgetTracing::where('budget_id',$budget->id)->get();
        //$tracings=BudgetTracing::all();

        return view('admin.budgets.tracing',compact('styles','budget','tracings'));
    }

    public function createRegTracing(Budget $budget)
    {
        $styles=Style::all();
        $employees=Employee::all();
        $tasks_list=Task::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('nombre','id');
        $tasks=Task::all();
        $optionAttributes = [];
        foreach ($tasks as $task) {
            $optionAttributes[$task->id] = [
                'id'            =>'Seaginnaenlavew',
                'data-costh' => $task->precio_hora,
                'class'=>'option'
            ];
        }
        $hours=[
            1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'10',10=>'11',11=>'12',12=>'13',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20',21=>'21',22=>'22',23=>'23',24=>'24'
        ];
        return view('admin.budgets.createregtracing',compact(
                                                                'budget',
                                                                'hours',
                                                                'styles',
                                                                'employees',
                                                                'tasks_list',
                                                                'tasks',
                                                                'optionAttributes'));
    }



    public function  tracingEdit(BudgetTracing $tracing)
    {
        $styles=Style::all();
        $employees=Employee::all();
        $tasks_list=Task::all()->sortBy('name',SORT_NATURAL | SORT_FLAG_CASE)->pluck('nombre','id');
        $tasks=Task::all();
        $optionAttributes = [];
        foreach ($tasks as $task) {
            $optionAttributes[$task->id] = [
                'id'            =>'Seaginnaenlavew',
                'data-costh' => $task->precio_hora,
                'class'=>'option'
            ];
        }
        $hours=[
            1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'10',10=>'11',11=>'12',12=>'13',13=>'13',14=>'14',15=>'15',16=>'16',17=>'17',18=>'18',19=>'19',20=>'20',21=>'21',22=>'22',23=>'23',24=>'24'
        ];
        $budget=Budget::where('id',$tracing->budget_id)->first();
        return view('admin.budgets.editregtracing',compact(     'budget',
                                                                'tracing',
                                                                'hours',
                                                                'styles',
                                                                'employees',
                                                                'tasks_list',
                                                                'tasks',
                                                                'optionAttributes'));

    }

    public function tracingStore(Budget $budget,Request $request)
    {
        $request->validate(
            [
                'fecha'=>'required',
                'employee_id'=>'required',
                //'task_id'=>'required',
                'desde'=>'required',
                'hasta'=>'required',
                'asistencia'=>'required',
                'jornal'=>'required',
                'pago'=>'required'
            ]
        );

        $request->merge([
            'budget_id'=>$budget->id
        ]);

        $tracing=BudgetTracing::create($request->all());
        Alert::toast('Se asigno la tarea al empleado correctamente','success');
        return redirect()->route('admin.budgets.tracing',compact('budget'));

    }

    public function tracingUpdate(BudgetTracing $tracing, Request $request)
    {
        $request->validate(
            [
                'fecha'=>'required',
                'employee_id'=>'required',
                //'task_id'=>'required',
                'desde'=>'required',
                'hasta'=>'required',
                'asistencia'=>'required',
                'jornal'=>'required',
                'pago'=>'required'
            ]
        );


        $request->merge([
            'budget_id'=>$tracing->budget_id
        ]);
        $budget=Budget::where('id',$tracing->budget_id)->first();

        $tracing->update($request->all());
        Alert::toast('El seguimiento se actualizó correctamente','success');
        return redirect()->route('admin.budgets.tracing',compact('budget'));
    }




    public function storeTracingRegister(Budget $budget, Request $request)
    {

    }

    public function tracingDestroy(BudgetTracing $tracing)
    {
        $budget=Budget::where('id',$tracing->budget_id)->first();
        $tracing->delete();
        Alert::toast('El seguimiento se eliminó con exitó','success');
        return redirect()->route('admin.budgets.tracing',compact('budget'));
    }

}
