<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'price',
        'image',
        'user_id',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = Str::replaceFirst('public/', 'storage/', $value);
    }

    public function scopeSearch($query, $val)
    {
        return $query
            ->where('name', 'like', '%' . $val . '%');
    }

    public function getDateForHumansAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function isInCart()
    {
        return $this->hasOne(CartItem::class)->where('user_id', auth()->user()->id);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
