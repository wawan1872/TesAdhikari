<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['title', 'body', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

