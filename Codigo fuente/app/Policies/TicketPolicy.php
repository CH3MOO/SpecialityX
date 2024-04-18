<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TicketPolicy
{
    use HandlesAuthorization;

    public function authorTicket(User $user, Ticket $ticket){
        if($user->id==$ticket->user_id || Auth::user()->roles->first()->name=="Administrador"){//si es el autor o administrador
            return true;
        }
        else{
            return false;
        }
    }


}
