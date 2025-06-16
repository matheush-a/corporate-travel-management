<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requester_name',
        'destination',
        'departure_date',
        'return_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'datetime',
            'return_date' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updatable($travelRequest)
    {
        /**
         * O status só pode ser alterado se a data de partida for superior a 7 dias em relação à data atual
         */
        if ($travelRequest->departure_date <= now()->addDays(7)) {
            return false;
        }

        return true;
    }
}
