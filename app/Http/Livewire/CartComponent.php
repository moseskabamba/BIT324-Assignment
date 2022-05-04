<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Custom\CartTask;
use App\Exports\CartItemsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;



class CartComponent extends Component
{

    // public function remove(Request $request)
    // {
    //     if($request->id) {
    //         $cart = session()->get('cart');
    //         if(isset($cart[$request->id])) {
    //             unset($cart[$request->id]);
    //             session()->put('cart', $cart);
    //         }
    //         session()->flash('success', 'Product removed successfully');
    //     }
    // }


    public $cart;

    public function mount()
    {
        // SearchSession::clearSession();
        $this->load_cart_sums();
    }

    public function load_cart_sums()
    {
        if (Auth::check()) {
            CartTask::transferSessionCartToDB();
            $this->cart = CartItem::where('user_id', auth()->user()->id)->with('product')->get()->toArray();
            foreach ($this->cart as $key => $cart) {
                $this->cart[$key]['total'] = $cart['price'] * $cart['quantity'];
            }
        } else {
            $cart = session()->get('cart');
            if (is_array($cart)) {
                $this->cart = $cart;
            }
        }
    }

    // public function render()
    // {
    //     $keyword = ['keyword'=>"", 'search_type'=>""];
    //     return view('livewire.cart-component')
    //         ->extends('layouts.store', ['keyword' => $keyword]);
    // }

    public function removeProductFromCart($id)
    {
        CartTask::deleteProductFromCart($id);
        $this->emit('cartItemChange');
        $this->load_cart_sums();
    }

    public function increment($key)
    {
        $cart = $this->cart[$key];
        // Check if there is stock
        // $hasStock = StockManager::checkItemStock($cart['product_id'], $cart['quantity']);
        // if ($hasStock) {
            if (Auth::check()) {
                CartItem::find($this->cart[$key]['id'])->update(['quantity' => $this->cart[$key]['quantity'] + 1]);
                $this->calculateTotal($key);
            } else {
                $cart = session()->get('cart');
                $id = $key;

                if (isset($cart[$id])) {
                    $cart[$id]['quantity']++;
                    $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
                    session()->put('cart', $cart);

                    session()->flash('message', 'Product added to cart successfully!');
                }
            }
            $this->emit('cartItemChange');
        // } else {
        //     session()->flash('message', 'This Product does not have any more stock!');
        // }
        $this->load_cart_sums();
    }

    public function decrement($key)
    {

        if (Auth::check()) {
            if ($this->cart[$key]['quantity'] > 0) {

                CartItem::find($this->cart[$key]['id'])->update(['quantity' => $this->cart[$key]['quantity'] - 1]);
            }
            $this->calculateTotal($key);
        } else {
            $cart = session()->get('cart');
            $id = $key;

            if ($cart[$id]['quantity'] > 1) {
                if (isset($cart[$id])) {
                    $cart[$id]['quantity']--;
                    $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
                    session()->put('cart', $cart);

                    session()->flash('message', 'Product added to cart successfully!');
                }
            }
        }
        $this->load_cart_sums();

    }

    public function updatequantity($key)
    {
        $cart = $this->cart[$key];
        // Check if there is stock
        // $hasStock = StockManager::checkItemStock($cart['product_id'], $cart['quantity']);
        // if ($hasStock) {
            // dd($this->cart[$key]['quantity']);
            if ($this->cart[$key]['quantity'] != null) {

                if ($this->cart[$key]['quantity'] == 0) {
                    $this->cart[$key]['quantity'] = 1;
                } else {
                    if (Auth::check()) {
                        CartItem::find($this->cart[$key]['id'])->update(['quantity' => $this->cart[$key]['quantity']]);
                    } else {
                        $cart = session()->get('cart');
                        $id = $key;

                        if (isset($cart[$id])) {
                            $cart[$id]['quantity'] = $this->cart[$id]['quantity'];
                            $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
                            session()->put('cart', $cart);

                            session()->flash('message', 'Product added to cart successfully!');
                        }
                    }
                }
                $this->load_cart_sums();
            } else {
                $this->cart[$key]['quantity'] = null;
            }
        // }else{
        //     session()->flash('message', 'This Product does not have any more stock!');
        // }
    }

    public function calculateTotal($key)
    {
        $this->cart[$key]['total'] = $this->cart[$key]['quantity'] * $this->cart[$key]['price'];
        if (Auth::check()) {
            CartItem::find($this->cart[$key]['id'])->update(['total' => $this->cart[$key]['total']]);
        }

    }

    public function clearCart()
    {
        $this->clearLocalStorage();

        if (Auth::check()) {
            CartItem::whereStatusId(1)->delete();
        }
        return redirect()->route('cart');
    }

    public function clearLocalStorage(){
        if (session()->get('cart')) {
            session()->forget('cart');
        }
    }

    public function downloadQuotation()
    {
        return Excel::download(new CartItemsExport, 'Quotation.xlsx');
    }

    public function render()
    {
        $cart = CartItem::where('user_id', auth()->user()->id)->with('product')->get()->toArray();
        return view('livewire.cart-component', compact('cart'));
    }
}
