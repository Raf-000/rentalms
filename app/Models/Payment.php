<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'paymentID';
    
    protected $fillable = [
        'billID',
        'tenantID',
        'receiptImage',
        'paymentMethod',
        'paidAt',
        'verifiedBy',
        'verifiedAt'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'billID', 'billID');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenantID', 'id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifiedBy', 'id');
    }
}