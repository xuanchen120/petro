<?php

namespace XuanChen\Petro\Models;

use App\Models\Model;

class PetroLog extends Model
{
    public $casts = [
        'in_source'  => 'json',
        'out_source' => 'json',
    ];
}
