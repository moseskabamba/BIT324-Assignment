<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartItemCount extends Component
{

    protected $listeners = ['cartItemChange' => 'changeCartItemCount'];
    public $cart;

    public function changeCartItemCount()
    {
        // if(Auth::check()){
        //     $this->cart = CartItem::where('user_id',auth()->user()->id)->with('product')->get()->toArray();
        // }else{
        //     $cart = session()->get('cart');
        //     // Check if array exists
        //     if(is_array($cart)){
        //         $this->cart = $cart;
        //     }
        // }

        $this->initializeCart();
    }

    /**
     * Initializes the cart, if the user is logged in, it gets the card from the DB
     * If the user is not signed in, get the cart from the session.
    */
    public function initializeCart()
    {
        if(Auth::check()){
            $this->cart = CartItem::where('user_id',auth()->user()->id)->with('product:id,name,image')->get()->toArray();
        }else{
            $cart = session()->get('cart');
            // Check if array exists
            if(is_array($cart)){
                $this->cart = $cart;
            }
        }
    }


    public function removeProductFromCart($id)
    {
        $this->emit('cartItemChange');
        if(Auth::check()){
            CartItem::where('id', $id)->delete();
        }else{
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function increment($key)
    {
        if(Auth::check()){
            CartItem::find($this->cart[$key]['id'])->update(['quantity'=>$this->cart[$key]['quantity']+1]);
            // $this->calculateTotal($key);
        }else{
            $cart = session()->get('cart');
            $id = $key;

            if(isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
                session()->put('cart', $cart);

                session()->flash('success', 'Product added to cart successfully!');
            }
        }
    }


    public function decrement($key)
    {
        if(Auth::check())
        {
            if($this->cart[$key]['quantity']>1){
                CartItem::find($this->cart[$key]['id'])->update(['quantity'=>$this->cart[$key]['quantity']-1]);
            }
            // $this->calculateTotal($key);
        }else{
            $cart = session()->get('cart');
            $id = $key;

            if($cart[$id]['quantity']>1){
                if(isset($cart[$id])) {
                    $cart[$id]['quantity']--;
                    $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
                    session()->put('cart', $cart);

                    session()->flash('success', 'Product added to cart successfully!');
                }
            }

        }
    }


    public function render()
    {
        $this->initializeCart();
        return view('livewire.cart-item-count');
    }
}
