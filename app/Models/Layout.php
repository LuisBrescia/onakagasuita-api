<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Layout extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'layouts';
    protected $guarded = [];

    public function salao()
    {
        return $this->belongsTo(Salao::class);
    }
}
