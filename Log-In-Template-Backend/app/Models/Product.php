<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes,Uuids;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id')->select('id','name');
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = round($value, 2);
    }
}
