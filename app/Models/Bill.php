<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'billID';
    
    protected $fillable = [
        'tenantID',
        'amount',
        'dueDate',
        'status'
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenantID', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'billID', 'billID');
    }
}