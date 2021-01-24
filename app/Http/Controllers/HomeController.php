<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\OrderItem;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $title = "Home";
        $best_sellers = OrderItem::select('product_id')->groupBy('product_id')->orderByRaw('SUM(quantity) DESC')->limit(2)->get();


        $categories = Category::inRandomOrder()->limit(6)->get();

        $products_limit = Product::whereHas('stocks', function ($query) {
                    $query->where('quantity', '>', 0);
                })->orderBy('id', 'desc')->limit(12)->get();

        $products_limit_all = Product::whereHas('stocks', function ($query) {
                    $query->where('quantity', '>', 0);
                })->inRandomOrder()->limit(12)->get();
        $products = Product::orderBy('id', 'desc')->get();

        return view('home', [
        'title' => $title,
        'categories' => $categories,
        'products_limit' => $products_limit,
        'products_limit_all' => $products_limit_all,
        'products' => $products,
        'best_sellers' => $best_sellers
        ]);
    }

}
