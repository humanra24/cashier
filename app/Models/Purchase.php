<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\Purchase_detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->format('H:m:s d-m-Y');
    }

    public function details()
    {
        return $this->hasMany(Purchase_detail::class);
    }
}
