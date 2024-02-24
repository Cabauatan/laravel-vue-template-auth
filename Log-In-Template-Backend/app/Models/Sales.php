<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory, Notifiable, SoftDeletes,Uuids;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->hasMany(SalesItem::class)->select('id','sales_id','product_id','sub_total','qty')->with('product');
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['total_amount'] = round($value, 2);
    }
}
