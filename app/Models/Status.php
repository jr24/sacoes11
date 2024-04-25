<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;
use Spatie\Permission\Traits\HasRoles;
use App\States\DetailState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    use HasFactory, HasRoles, HasStates;

    protected $table = 'statuses';

    protected $casts =['state' => DetailState::class];

    protected $fillable = [
        'state',
        'date',
        'observation',
        'idDetail',
        'idUser'
    ];

    public function detail():BelongsTo{
        return $this->belongsTo(Detail::class, 'idDetail');
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'idUser');
    }
}
