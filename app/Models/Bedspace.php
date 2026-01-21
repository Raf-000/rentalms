<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bedspace extends Model
{
    protected $table = 'bedspaces';
    protected $primaryKey = 'unitID';
    
    protected $fillable = [
        'unitCode',
        'houseNo',
        'floor',
        'roomNo',
        'bedspaceNo',
        'price',
        'restriction',
        'tenantID',
        'status'
    ];

    // Relationship to tenant
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenantID', 'id');
    }
}