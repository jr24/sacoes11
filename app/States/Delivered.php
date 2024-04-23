<?php

namespace App\States;

class Delivered extends DetailState
{
    public static $name = 'delivered';
    public function color(): string
    {
        return 'purple';
    }
}