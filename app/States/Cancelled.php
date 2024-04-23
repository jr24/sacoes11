<?php

namespace App\States;

class Cancelled extends DetailState
{
    public static $name = 'cancelled';
    public function color(): string
    {
        return 'red';
    }
}