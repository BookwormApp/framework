<?php

namespace Bookworm\Support\Entities;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

abstract class Model extends Eloquent
{
    public function scopeRandom($query)
    {
        if (DB::connection()->getDriverName() == 'sqlite') {
            return $query->orderByRaw('RANDOM()');
        } elseif (DB::connection()->getDriverName() == 'mysql') {
            return $query->orderByRaw('RAND()');
        }

        return $query;
    }
}
