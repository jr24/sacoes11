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
        'idAdminReceptionist',
        'idCustomer',
        'idTailor' 
    ];

    public function details():HasMany{
        return $this->hasMany(Detail::class, 'idOrder');
    }

    public function adminReceptionist():BelongsTo{
        return $this->belongsTo(User::class, 'idAdminReceptionist');
    }

    public function tailor():BelongsTo{
        return $this->belongsTo(User::class, 'idTailor');
    }

    public function customer():BelongsTo{
        return $this->belongsTo(User::class, 'idCustomer');
    }
}
