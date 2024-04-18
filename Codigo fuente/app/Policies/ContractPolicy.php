<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ContractPolicy
{
    use HandlesAuthorization;

    public function authorContract(User $user, Contract $contract)
    {

        if($user->id==$contract->user_id || Auth::user()->roles->first()->name=="Administrador"){//si es el autor o administrador
            return true;
        }
        else{
            return false;
        }
    }
}
