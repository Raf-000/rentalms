<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $table = 'maintenance_requests';
    protected $primaryKey = 'requestID';
    
    protected $fillable = [
        'tenantID',
        'description',
        'photo',
        'status'
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenantID', 'id');
    }

    
}