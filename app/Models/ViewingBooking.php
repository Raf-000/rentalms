<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'bedspace_id',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    // Relationship to bedspace
    public function bedspace()
    {
        return $this->belongsTo(Bedspace::class, 'bedspace_id', 'unitID');
    }
}