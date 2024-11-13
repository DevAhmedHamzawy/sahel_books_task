<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guarded = [];

    public function getImgPathAttribute()
    {
        return $this->image != null ? url('storage/admins/'.$this->image) :  url('assets/img/user_default.png');
    }
}
