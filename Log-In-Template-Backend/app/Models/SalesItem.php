<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesItem extends Model
{
    use HasFactory, Notifiable, SoftDeletes,Uuids;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->select('id','name','category_id','price','stock_qty',)->with('category');
    }
    public function sale()
    {
        return $this->belongsTo(Sales::class,'sales_id');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['unit_price'] = round($value, 2);
        $this->attributes['sub_total'] = round($value, 2);
    }

}
