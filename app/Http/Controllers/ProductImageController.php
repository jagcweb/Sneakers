<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function deleteImage($id){
        $product_image = ProductImage::find($id);
        
        if($product_image){
             \Storage::disk('products')->delete($product_image->image);
             
             $product_image->delete();
        }
        return redirect()->route('product.edit', ['id' => $product_image->product_id])->with(['message' => 'Deleted image

']);
    }
}
