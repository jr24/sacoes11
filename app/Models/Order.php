<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'startDate',
        'endDate',
        'description',
        'priority',
        'idAdminRecepcionista',
        'idCliente',
        'idSastre' 
    ];

    public function details():HasMany{
        return $this->hasMany(Detail::class, 'idOrder');
    }

    public function adminRecepcionista():BelongsTo{
        return $this->belongsTo(User::class, 'idAdminRecepcionista');
    }

    public function sastre():BelongsTo{
        return $this->belongsTo(User::class, 'idSastre');
    }

    public function cliente():BelongsTo{
        return $this->belongsTo(User::class, 'idCliente');
    }
}
