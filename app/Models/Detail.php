<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Detail extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'typeGarment',
        'quantity',
        'costUnit',
        'idOrder'
    ];

    public function order():BelongsTo{
        return $this->belongsTo(Order::class, 'idOrder');
    }
}
