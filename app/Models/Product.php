<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    
    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }
    
    public function stocks(){
        return $this->hasMany(Stock::class);
    }
    
    public function brands(){
        return $this->hasMany(Brand::class);
    }
    
    public function childs(){
        return $this->hasMany(Child::class);
    }
    
    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function cart_items(){
        return $this->hasMany(CartItem::class);
    }
}
