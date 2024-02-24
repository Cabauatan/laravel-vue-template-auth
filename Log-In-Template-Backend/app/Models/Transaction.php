<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, Notifiable, SoftDeletes,Uuids;
    protected $guarded = [];

    public function sale()
    {
        return $this->belongsTo(Sales::class,'sales_id');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['vat'] = round($value, 2);
        $this->attributes['total_payment'] = round($value, 2);
        $this->attributes['payment'] = round($value, 2);
        $this->attributes['change'] = round($value, 2);
    }
}
