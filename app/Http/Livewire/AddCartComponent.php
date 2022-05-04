<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
// use App\Custom\StockManager;
use Livewire\Component;
// use App\Custom\SearchSession;

class AddCartComponent extends Component
{
    use AuthorizesRequests;
    public $product;
    public $product_id;
    public $cart;

    public function render()
    {
        // If the users is not logged in, add item to session
        if (Auth::check()) {
            $this->cart = CartItem::where('user_id', auth()->user()->id)
                ->whereProductId($this->product->id)
                ->with('product')->first();
        } else {
            if (session()->has('cart')) {
                $this->cart = session()->get('cart');
            }
            // dd($this->cart);
        }
        return view('livewire.add-cart-component');
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        // SearchSession::clearSession();
    }

    public function addToCart()
    {
        // Register the add to cart changed event
        $this->emit('cartItemChange');
        // If the user is logged in,
        if (Auth::check()) {
            $cart = CartItem::where('product_id', $this->product->id)
                ->where('user_id', auth()->user()->id)
                ->where('status_id', 1)->first();

            if (!$cart) {
                // If cart is empty create a cart item
                CartItem::firstOrCreate([
                    "user_id" => auth()->user()->id,
                    // "team_id" => auth()->user()->currentTeam->id,
                    "product_id" => $this->product->id,
                    "price" => str_replace( ',', '', $this->product->price),
                    "quantity" => 1,
                    "total" => str_replace( ',', '', $this->product->price)
                ]);
            }
            else{
                // Check the Quantity
                // $hasStock = StockManager::checkItemStock($this->product->id, $this->cart['quantity']);
                // if ($hasStock) {
                    CartItem::find($cart->id)->update([
                        'quantity' => $this->cart['quantity'] + 1,
                        'total' => str_replace( ',', '', $this->product->price) * $this->cart['quantity'] + 1]);
                // } else {
                    session()->put('success', 'Product has run out of stock!');
                // }
            }
        } else {
            // Create a Cart
            $cart = session()->get('cart');
            $id = $this->product->id;

            // if cart is empty then this the first product
            if (!$cart) {
                $cart = [
                    $id => [
                        "product_id" => $this->product->id,
                        "price" => str_replace( ',', '', $this->product->price),
                        "quantity" => 1,
                        "name" => $this->product->name,
                        "image" => $this->product->image,
                        "total" => str_replace( ',', '', $this->product->price),
                    ],
                ];

                session()->put('cart', $cart);
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
                    "product_id" => $this->product->id,
                    "price" => str_replace( ',', '', $this->product->price),
                    "quantity" => 1,
                    "name" => $this->product->name,
                    "image" => $this->product->image,
                    "total" => str_replace( ',', '', $this->product->price),
                ];
                session()->put('cart', $cart);
            }
        }
    }
}
