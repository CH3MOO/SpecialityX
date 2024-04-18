<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'contract_id',
        'amount',
        'name',
        'description',
        'answer',
        'ticket_type_id',
        'status',//abierto-cerrado
        'approved',//1 si, 0 no
        'name',
        'last_name',
        'country',
        'state',
        'city',
        'identity_document_name',
        'identity_document_number',
        'wallet',
        'phone_number',
        'email',
        'close_date',
        'name_old',
        'last_name_old',
        'country_old',
        'state_old',
        'city_old',
        'identity_document_name_old',
        'identity_document_number_old',
        'wallet_old',
        'phone_number_old',
        'email_old',
    ];







    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticket_type(){
        return $this->belongsTo(TicketType::class);
    }
}
