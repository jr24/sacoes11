<?php

namespace App\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<\App\Models\Detail>
 */
abstract class DetailState extends State
{
    abstract public function color(): string;

    public static function config(): StateConfig
    {
        return parent::config()
        ->default(Pending::class)
        ->allowTransition(Pending::class, Starting::class)
        ->allowTransition(Pending::class, Cancelled::class)
        ->allowTransition(Starting::class, Testing::class)
        ->allowTransition(Testing::class, Starting::class)
        ->allowTransition(Testing::class, Finished::class)
        ->allowTransition(Finished::class, Delivered::class);
    }
}