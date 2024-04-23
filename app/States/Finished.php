<?php

namespace App\States;

class Finished extends DetailState
{
    public static $name = 'finished';
    public function color(): string
    {
        return 'green';
    }
}