<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomeComponent extends Component
{
    use WithPagination, AuthorizesRequests;

    public $per_page = 10;
    public $search = '';
    public $product;
    public $product_id;
    public $cart;


    public function mount()
    {
        $this->per_page;
    }

    public function addToCart($id)
    {
        $product = Product::find($id);
        // dd($product);
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

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function render()
    {
        $products = Product::search($this->search)
            ->paginate($this->per_page);

        return view('livewire.home-component', compact('products'));
    }
}
