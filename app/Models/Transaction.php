<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
