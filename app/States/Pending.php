<?php

namespace App\States;


class Pending extends DetailState
{
    public static $name = 'pending';
    public function color(): string
    {
        return 'yellow';
    }
}