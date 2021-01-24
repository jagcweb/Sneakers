<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;
    
    protected $table = 'childs';
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
