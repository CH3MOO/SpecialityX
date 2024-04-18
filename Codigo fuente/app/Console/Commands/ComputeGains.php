<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Models\Gain;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ComputeGains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:gains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proceso que corre diariamente para calcular las ganancias obtenidas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->computeDailyGains();
        return 0;
    }

    private function computeDailyGains()
    {
        //echo "listo";
        //$contracts=Contract::all();
        //return $contracts;
        $contracts=Contract::where('start_date','<>',null)//el contrato ya inicion
                            ->where('end_date','>',Carbon::today())//la fecha de fin aun no se vence
                            ->where('contract_status_id',2)//el contrato está activo
                            ->get();

        foreach($contracts as $contract)
        {
            $daily_gain=Gain::create([
                'gain_type_id'=>1,//ganancia de tipo diaria
                'contract_id'=>$contract->id,//El contrato
                'amount'=>($contract->initial_deposit/50),
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
    }
}
