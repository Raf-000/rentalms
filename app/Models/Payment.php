<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'paymentID';

    protected $fillable = [
        'billID',
        'tenantID',
        'receiptImage',
        'paymentMethod',
        'paidAt',
        'verifiedBy',
        'verifiedAt',
        'rejectionReason',  // Make sure this is here
        'rejectedBy',       // Make sure this is here
        'rejectedAt',       // Make sure this is here
    ];

    protected $casts = [
        'paidAt' => 'datetime',
        'verifiedAt' => 'datetime',
        'rejectedAt' => 'datetime',
    ];

    // Relationships
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

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejectedBy', 'id');
    }
}