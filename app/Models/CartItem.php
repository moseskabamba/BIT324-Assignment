<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id', 'quantity', 'price', 'total'];

    protected static function booted()
    {
        static::created(
            function ($model) {
                $model->total = $model->price;
            }
        );

        static::updating(
            function ($model) {
                $model->total = $model->quantity * $model->price;
            }
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function productCartDetail($product_id){
        if(Auth::check()){
            $data = CartItem::where('product_id', $product_id)
            ->where('user_id', auth()->user()->id)
            ->where('status_id', 1)->get()->first();
            if ($data == null) {
                return 0;
            }else {
                return $data->quantity;
            }
        }
    }
}
