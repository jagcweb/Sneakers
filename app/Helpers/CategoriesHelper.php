<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesForHome {

    public static function catsForHome(){
        $cats = Category::inRandomOrder()->limit(6)->get();
        
        return $cats;
    }
    

}
