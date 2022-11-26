<?php

namespace Larso\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class LaravelModel extends Eloquent
{
    /**
     * Indicates if the model should be timestamped. Turn off by default.
     *
     * @var bool
     */
    public $timestamps = false;
}
