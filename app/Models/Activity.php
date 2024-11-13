<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function getTheStartTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('Y-m-d') . '<br>' . Carbon::parse($this->start_time)->format('h:i A');
    }

    public function getTheEndTimeAttribute()
    {
        return Carbon::parse($this->end_time)->format('Y-m-d') . '<br>' . Carbon::parse($this->end_time)->format('h:i A');
    }
}
