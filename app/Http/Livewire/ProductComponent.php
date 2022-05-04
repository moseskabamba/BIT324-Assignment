<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Product;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithFileUploads, WithPagination;

    public User $user;
    public Product $product;
    public $search = '';
    public $per_page = 5;
    public $showForm = false;
    public $deleteForm = false;
    public $sortField = 'name';
    public $sortDirection = "asc";
    public $progress;
    public $isUploading;
    public $image;

    protected $queryString = ['sortField', 'sortDirection'];

    public function mount()
    {
        $this->makeBlankProduct();
        $this->progress = ([100, 0]);
    }

    public function sortBy($field)
    {
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function rules()
    {
        return [
            'product.name'=> ['required'],
            'product.price'=> ['required'],
            'product.quantity'=>['required'],
            'product.user_id'=> ['required'],
            'image'=>'required|max:5120'
        ];
    }

    public function addProduct()
    {
        if($this->product->getKey()) {
            $this->product = $this->makeBlankProduct();
        }
        $this->showForm = true;
    }

    public function saveProduct()
    {

        // $this->validate();

        $this->product->user_id = auth()->id();
        $this->product->image= $this->image->store('photos','public');
        $this->product->save();

        $this->showForm = false;
        $this->makeBlankProduct();

    }

    public function makeBlankProduct()
    {
        $this->product = Product::make();
    }

    public function clearStates()
    {
        $this->showForm=false;
        $this->deleteForm=false;
    }

    public function edit(Product $product)
    {
        if($this->product->isNot($product)) {
            $this->product = $product;
        }

        $this->showForm = true;
    }

    public function startDelete(Product $product)
    {
        $this->product = $product;
        $this->deleteForm = true;
    }

    public function delete()
    {
        $this->product->delete();
        $this->deleteForm = false;

        session()->flash('message', 'You deleted the product');
        session()->flash('alert-type', 'success');
    }

    public function render()
    {
        $products = Product::where('user_id',auth()->id())->search($this->search)
        ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->per_page);
        return view('livewire.product-component', compact('products'));
    }
}
