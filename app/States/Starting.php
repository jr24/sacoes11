<?php

namespace App\States;

class Starting extends DetailState
{
    public static $name = 'starting';
    public function color(): string
    {
        return 'blue';
    }
}