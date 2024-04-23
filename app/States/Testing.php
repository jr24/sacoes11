<?php

namespace App\States;

class Testing extends DetailState
{
    public static $name = 'testing';
    public function color(): string
    {
        return 'orange';
    }
}