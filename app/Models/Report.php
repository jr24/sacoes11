<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;
use App\States\DetailState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory, HasStates;

    protected $cast = [
        'state' => DetailState::class
    ];

    protected $fillable = [
        'state',
        'description',
        'idDetail'
    ];

    public function detail():BelongsTo{
        return $this->belongsTo(Detail::class, 'idDetail');
    }
}
