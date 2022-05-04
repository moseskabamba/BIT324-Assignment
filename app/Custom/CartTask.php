<?php
namespace App\Custom;
use App\Models\CartItem;
use App\Custom\StockManager;
use App\Custom\CheckoutManager;
use App\Models\Product;
use App\Models\FacilitationFee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CartTask{

    use AuthorizesRequests;
    protected $product;
    public $product_id;
    public $cart;

    public static function transferSessionCartToDB(){

        // dd($checkCart);
        if (Auth::check()) {
            $checkCart = CartItem::where('user_id', auth()->user()->id)->get();
            // dd($checkCart);
            $cart = session()->get('cart');
            if(!empty($cart)){
                // transfer the cart items in local storage to the database
                // if 'local storage is not empty'
                foreach ($cart as $item) {
                    $x = $checkCart->where('product_id', $item['product_id']);
                    if($x->count() == 1){
                        $row = CartItem::find($x->first()->id);
                        $row->increment('quantity', $item['quantity']);
                        $row->save();

                    }else{
                        CartItem::firstOrCreate([
                            "user_id" => auth()->user()->id,
                            // "team_id" => auth()->user()->currentTeam->id,
                            "product_id" => $item['product_id'],
                            "price" => $item['price'],
                            "quantity" => $item['quantity'],
                        ]);
                    }
                }
                // clear the local storage cart
                if (session()->get('cart')) {
                    session()->forget('cart');
                }
            }
        }
    }

    public static function addToCart($id)
    {
        $product = Product::find($id);
        // Register the add to cart changed event
        // If the user is logged in,
        if (Auth::check()) {
            $cart = CartItem::where('product_id', $id)
                ->where('user_id', auth()->user()->id)
                ->where('status_id', 1)->first();

            if (empty($cart)) {
                // If cart is empty create a cart item
                CartItem::firstOrCreate([
                    "user_id" => auth()->user()->id,
                    // "team_id" => auth()->user()->currentTeam->id,
                    "product_id" => $product->id,
                    "price" => str_replace(",", "", $product->price),
                    "quantity" => 1,
                    "total" => str_replace(",", "", $product->price) * 1
                ]);
            }
            // else{
            //     // Check the Quantity
            //     $hasStock = StockManager::checkItemStock($product->id, $cart->quantity);
            //     if ($hasStock) {
            //         CartItem::find($cart->id)->update(['quantity' => $cart->quantity + 1, 'total' => str_replace(",", "", $product->price) * $cart->quantity + 1]);
            //     } else {
            //         session()->put('success', 'Product has run out of stock!');
            //     }
            // }
        } else {
            // Create a Cart
            $cart = session()->get('cart');
            $id = $product->id;
            // dd($cart);
            // if cart is empty then this the first product
            if (!$cart) {
                $data[$id] = [
                    "product_id" => $product->id,
                    "price" => $product->price,
                    "quantity" => 1,
                    "name" => $product->name,
                    "image" => $product->image,
                    "total" => $product->price,
                ];

                session()->put('cart', $data);
                $check = session()->put('cart', $data);
            }

            // if cart not empty then check if this product exist then increment quantity
            elseif (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
                session()->put('cart', $cart);

                session()->put('success', 'Product added to cart successfully!');

            } else {
                // if item not exist in cart then add to cart with quantity = 1
                $cart[$id] = [
                    "product_id" => $product->id,
                    "price" => $product->price,
                    "quantity" => 1,
                    "name" => $product->name,
                    "image" => $product->image,
                    "total" => $product->price,
                ];
                session()->put('cart', $cart);
            }
        }
    }
    public static function deleteProductFromCart($id){
        if (Auth::check()) {
            CartItem::where('id', $id)->delete();
            session()->flash('message', 'Product removed successfully');
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            session()->flash('message', 'Product removed successfully');
        }
    }

    public static function updateCartPrices($product)
    {
        $cart_items = CartItem::where('product_id', $product->id)->get();
        foreach($cart_items as $cart_item) {
            $cart_item->update([
                'price' => str_replace(",", "", $product->price),
                'total' => $cart_item->quantity * str_replace(",", "", $product->price)
            ]);
        }
    }

    // public static function updateOrdersPrices($total, $order)
    // {
    //     $facilitation = 0.00;
    //     if($order->facilitation_fee != "0.00") {
    //         $charge = FacilitationFee::where('floor', '<=', $total)
    //         ->where('ceiling', '>=', $total)
    //         ->where('status_id', 1)
    //         ->first();
    //         $charge == null ? $facilitation = 0.00 : ($charge->type == 1 ? $facilitation = $charge->value : $facilitation = $total * $charge->value/100);
    //     }

    //     $order->update(['total' => $total + $facilitation + $order->delivery_fee,
    //         'facilitation_fee' => round($facilitation, 2)
    //     ]);
    // }

    // public static function updateOrderItemsPrices($order)
    // {
    //     foreach($order->order_item as $item) {
    //         $item->update([
    //             'price' => str_replace(",", "", $item->product->price),
    //             'total' => $item->quantity * str_replace(",", "", $item->product->price),
    //         ]);
    //     }
    //     CheckoutManager::deductCommission($order->id);
    // }
}
