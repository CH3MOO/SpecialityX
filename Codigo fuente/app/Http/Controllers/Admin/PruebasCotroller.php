<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Gain;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PruebasCotroller extends Controller
{
    public function calculaGanancias()
    {



        $contracts=Contract::where('start_date','<>',null)//el contrato ya inicion
                            ->where('end_date','>',Carbon::today())//la fecha de fin aun no se vence
                            ->where('contract_status_id',2)//el contrato está activo
                            ->get();



        foreach($contracts as $contract)
        {
            $daily_gain=Gain::create([
                'gain_type_id'=>1,//ganancia de tipo diaria
                'contract_id'=>$contract->id,//El contrato
                'amount'=>$contract->initial_deposit/5,
            ]);

            $gains=Gain::where('contract_id',$contract->id)//Ganancias diarias + invitados
                                ->get();
            $total_gain=0;
            foreach($gains as $gain)
            {
                $total_gain=$total_gain+$gain->amount;
            }
            $contract->update([
                'total_gain'=> $total_gain,
                'total_berlins'=>($contract->initial_deposit)/50
            ]);

            if($contract->total_gain >= $contract->initial_deposit * 2)//si se alcanzo el tope de ganancias entonces
            {
                echo "supero el limite \n";

                $contract->update(['contract_status_id'=>3]);//El contrato se pone como inactivo porque supero el limite de ganancias
            }
            else{
                echo "aun no supera el limite\n";
                echo $contract->total_gain. "\n";
                echo $contract->initial_deposit*2;
            }
        }






        /*

        $contracts=Contract::all();
        //return $contracts;
        $contracts=Contract::where('start_date','<>',null)
                            ->where('end_date','>',Carbon::now())
                            ->where('status',1)
                            ->get();
        foreach($contracts as $contract)
        {
            $last_gain=Gain::where('contract_id',$contract->id)
                        ->orderBy('id','desc')
                        ->first();
            if($last_gain!=null)
            {
                $new_gain=Gain::create([
                    'contract_id'=>$contract->id,
                    'amount'=>$last_gain->amount + $contract->initial_deposit/50
                ]);

                //echo "estamos aqui  \n";
                //echo $last_gain->amount."\n";
                //echo $contract->initial_deposit/50 ."\n";

            }
            else
            {
                $new_gain=Gain::create([
                    'contract_id'=>$contract->id,
                    'amount'=>$contract->initial_deposit/50//si se realiza el primer calgulo de ganancias
                ]);
            }
            $total_gain=$new_gain->amount;
            $contract->update([
                'total_gain'=> $total_gain,
                'total_berlins'=>($contract->initial_deposit)/5
            ]);
            return $contract;
        }
        */
    }
}
