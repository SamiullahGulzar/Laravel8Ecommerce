<?php

namespace App\Http\Livewire;

use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $sliders = HomeSlider::where('status', 1)->get();
        $lproducts = Product::orderBy('created_at', 'DESC')->get()->take(8);
        $sproducts = Product::where('sale_price','>', 0)->inRandomOrder()->get()->take(3);
        $sale = Sale::find(1);
        return view('livewire.home-component', ['sliders'=>$sliders, 'lproducts'=>$lproducts, 'sproducts'=> $sproducts, 'sale'=>$sale])->layout('layouts.base');
    }
}
