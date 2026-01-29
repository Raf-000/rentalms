<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewingBooking extends Model
{
    use HasFactory;

    protected $table = 'viewing_bookings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'bedspace_id',
        'preferred_date',
        'preferred_time',
        'message',
        'status'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship to Bedspace
    public function bedspace()
    {
        return $this->belongsTo(Bedspace::class, 'bedspace_id', 'unitID');
    }
}