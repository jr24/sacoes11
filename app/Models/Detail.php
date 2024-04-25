<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;
use Spatie\Permission\Traits\HasRoles;
use App\States\DetailState;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function statuses():HasMany{
        return $this->hasMany(Status::class, 'idDetail');
    }
}
