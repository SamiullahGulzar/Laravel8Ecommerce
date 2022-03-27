<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class CategoryComponent extends Component
{
    public $sorting;
    public $category_slug;

    public function mount($category_slug)
    {
        $this->category_slug = $category_slug;
    }

    public function sortby($value)
    {
        $this->sorting = $value;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name,1 , $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added in Cart');
        return redirect()->route('product.cart');
    }
    
    use WithPagination;
    public function render()
    {
        $category = Category::where('slug', $this->category_slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;

        if($this->sorting == 'newness') {
            $products = Product::where('category_id', $category_id)->orderBy('created_at','DESC')->paginate(12);

        } else if($this->sorting == 'price') {
            $products = Product::where('category_id', $category_id)->orderBy('regular_price','ASC')->paginate(12);

        } else if($this->sorting == 'price-desc') {
            $products = Product::where('category_id', $category_id)->orderBy('regular_price','DESC')->paginate(12);
            
        } else {
            $products = Product::where('category_id', $category_id)->paginate(12);
        }
        $categories = Category::all();
        
        return view('livewire.category-component', ['products'=> $products, 'categories'=> $categories, 'category_name'=>$category_name])->layout('layouts.base');
    }
}
