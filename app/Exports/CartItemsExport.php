<?php

namespace App\Exports;

use App\Models\CartItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CartItemsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cartItems = CartItem::with('product')->get();

        // dd($cartItems);
        foreach($cartItems as $cartItem)
        {
            $data []=[
                $cartItem->id,
                $cartItem->product->name,
                $cartItem->quantity,
                $cartItem->total,
                Carbon::parse($cartItem->created_at)->format('d/m/Y')

            ];
        }

        return new Collection([
            [
                'ID',
                'NAME',
                'QUANTITY',
                'TOTAL',
                'DATE'
            ],
            $data
        ]);
    }
}
