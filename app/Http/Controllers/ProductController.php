<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Stock;
use App\Models\Child;
use Illuminate\Http\Response;

class ProductController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except('getImage', 'detail', 'getAllForUsers', 'categoriesForUser' ,'search');
        $this->middleware('admin')->except('getImage', 'detail', 'getAllForUsers', 'categoriesForUser', 'search');
    }

    public function index() {
        return view('product.index');
    }

    public function create() {
        $categories = Category::all();
        return view('product.create', [
            'categories' => $categories
        ]);
    }

    public function save(Request $request) {

        $category_id = (int) $request->get('category_id');
        $name = $request->input('name');
        $brand = $request->input('brand');
        $price = (float) $request->input('price');
        $gender = $request->get('gender');
        $child_box = (int) $request->get('child');
        $discount = (int) $request->input('discount');
        $description = $request->get('description');
        $files = $request->file('image');

        $validate = $this->validate($request, [
            'category_id' => ['required', 'numeric', 'max:255'],
            'name' => ['required', 'string', 'max:100'],
            'brand' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric'],
            'gender' => ['required', 'string', 'max:1'],
            'child' => ['numeric', 'max:1'],
            'description' => ['required', 'string'],
            'image' => ['required'],
            'image.*' => ['image']
        ]);

        $name_str = str_replace(' ', '-', $name);

        $product = new Product();
        $product->category_id = $category_id;
        $product->name = $name_str;
        $product->brand = $brand;
        $product->price = $price;
        $product->gender = $gender;

        if ($discount != null) {
            $validate = $this->validate($request, [
                'discount' => ['numeric'],
            ]);
            $product->discount = $discount;
        } else {
            $product->discount = 0;
        }

        $product->description = $description;
        $product->save();

        if ($child_box) {
            $child = new Child();

            $child->product_id = $product->id;
            $child->child = $child_box;
            $child->save();
        } else {
            $child = new Child();

            $child->product_id = $product->id;
            $child->child = 0;
            $child->save();
        }

        if ($files && is_array($files) || $files && is_object($files)) {

            foreach ($files as $file) {

                //Instancia de ProductImage
                $product_image = new ProductImage();


                $file_name = time() . $file->getClientOriginalName();
                //Ya que vamos a guardar las imagenes en la tabla Product_images y no en la de Product
                //Tenemos que recoger el ID de product y hacer otro insert dentro de esa tabla
                $product_image->product_id = $product->id;

                //Guardar img
                $product_image->image = $file_name;

                //Hacemos el save
                $product_image->save();

                \Storage::disk('products')->put($file_name, \File::get($file));
            }
        } else {
            return redirect()->route('product.all')->with(['message' => 'Images not uploaded']);
        }

        return redirect()->route('product.all')->with(['message' => 'Product created!!']);
    }

    public function getImage($filename) {
        $file = \Storage::disk('products')->get($filename);

        return new Response($file, 200);
    }

    public function getAll() {
        $products = Product::all();

        return view('product.all', [
            'products' => $products
        ]);
    }

    public function delete($id) {
        $product = Product::find($id);

        if ($product) {
            foreach ($product->product_images as $product_images) {
                if ($product_images->image) {
                    \Storage::disk('products')->delete($product_images->image);
                }
            }
            $product->product_images()->delete();
            $product->stocks()->delete();
            $product->childs()->delete();
            $product->cart_items()->delete();
            $product->order_items()->delete();
            $product->delete();

            return redirect()->route('product.all')->with(['message' => 'Deleted product!']);
        } else {
            return redirect()->route('product.all');
        }
    }

    public function edit($id) {
        $categories = Category::all();
        $product = Product::find($id);

        return view('product.edit', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    public function update($id, Request $request) {
        $category_id = (int) $request->get('category_id');
        $name = $request->input('name');
        $brand = $request->input('brand');
        $price = (float) $request->input('price');
        $gender = $request->get('gender');
        $child_box = (int) $request->get('child');
        $discount = (int) $request->input('discount');
        $description = $request->get('description');
        $files = $request->file('image');

        $validate = $this->validate($request, [
            'category_id' => ['numeric', 'max:255'],
            'name' => ['string', 'max:100',],
            'brand' => ['string', 'max:100'],
            'price' => ['numeric'],
            'gender' => ['string', 'max:1'],
            'child' => ['numeric', 'max:1'],
            'image.*' => ['image']
        ]);

        if ($description != null) {
            $validate = $this->validate($request, [
                'description' => ['string'],
            ]);
        }

        $name_str = str_replace(' ', '-', $name);

        $product = Product::find($id);
        if ($product) {
            $product->category_id = $category_id;
            $product->name = $name_str;
            $product->brand = $brand;
            $product->price = $price;
            $product->gender = $gender;
            $product->discount = $discount;
            $product->description = $description;
            $product->update();

            if ($child_box) {
                foreach ($product->childs as $child) {
                    $child->product_id = $product->id;
                    $child->child = $child_box;
                    $child->update();
                }
            } else {
                foreach ($product->childs as $child) {
                    $child->product_id = $product->id;
                    $child->child = 0;
                    $child->update();
                }
            }

            if ($files && is_array($files) || $files && is_object($files)) {

                foreach ($files as $file) {

                    $product_image = new ProductImage();
                    $file_name = time() . $file->getClientOriginalName();

                    $product_image->product_id = $product->id;
                    $product_image->image = $file_name;

                    $product_image->save();

                    \Storage::disk('products')->put($file_name, \File::get($file));
                }
            }
        }

        return redirect()->route('product.all')->with(['message' => 'Edited product!!']);
    }

    public function detail($brand, $name) {
        $title = "Product Detail";
        $categories = Category::all();
        $products = Product::where('brand', '=', $brand)
                        ->where('name', '=', $name)->get();

        return view('product.detail', [
            'products' => $products,
            'categories' => $categories,
            'title' => $title
        ]);
    }

    public function stock($id) {
        $product = Product::find($id);

        return view('product.stock', [
            'product' => $product
        ]);
    }

    public function updateStock($id, Request $request) {
        $product = Product::find($id);

        $quantity = (int) $request->input('quantity');
        $size = (int) $request->input('size');

        foreach ($product->childs as $child) {
            var_dump($child->child);
            if ($product->gender == 'M' && $child->child == 0) {
                $validate = $this->validate($request, [
                    'quantity' => ['required', 'numeric'],
                    'size' => ['required', 'integer', 'between:36,50']
                ]);
            } elseif ($product->gender == 'W' && $child->child == 0) {
                $validate = $this->validate($request, [
                    'quantity' => ['required', 'numeric'],
                    'size' => ['required', 'integer', 'between:34,46']
                ]);
            } elseif ($product->gender == 'M' && $child->child == 1) {
                $validate = $this->validate($request, [
                    'quantity' => ['required', 'numeric'],
                    'size' => ['required', 'integer', 'between:19,35']
                ]);
            } else {
                $validate = $this->validate($request, [
                    'quantity' => ['required', 'numeric'],
                    'size' => ['required', 'integer', 'between:19,33']
                ]);
            }
        }

        if ($quantity && $size) {
            foreach ($product->stocks as $stocks_to_compare) {
                if ($stocks_to_compare->product_id == $product->id && $stocks_to_compare->size == $size) {
                    $stocks_to_compare->product_id = $product->id;
                    $stocks_to_compare->quantity += $quantity;
                    $stocks_to_compare->update();
                    return redirect()->route('product.stock', ['id' => $product->id])
                                    ->with(['message' => 'The size you are trying to add already exists, so we have added the stock entered to the existing stock']);
                }
            }
        } else {
            return redirect()->route('product.stock', ['id' => $product->id])->with(['message' => 'Error adding stock. You cant add']);
        }
        $stock = new Stock();
        $stock->product_id = $product->id;
        $stock->quantity = $quantity;
        $stock->size = $size;
        $stock->save();
        return redirect()->route('product.stock', ['id' => $product->id])->with(['message' => 'Stock added!!']);
    }

    public function getAllForUsers(Request $request, Product $products) {
        $gender = $request->get('gender');
        $child = $request->get('kids');
        $brand = $request->get('brand');
        $size = $request->get('size');
        $order = $request->get('order');
        $price_start = $request->input('price-start');
        $price_end = $request->input('price-end');

        $products = $products->newQuery();
        if ($request->has('gender') && !empty($gender)) {
            $products->where('gender', '=', $gender);
        }

        if ($request->has('kids') && !empty($child)) {
            $products->whereHas('childs', function($query) use ($child) {
                $query->where('child', '=', $child);
            });
        } else {
            $products->whereHas('childs', function($query) use ($child) {
                $query->where('child', '=', 0);
            });
        }

        if ($request->has('brand') && !empty($brand)) {
            $products->where('brand', '=', $brand);
        }

        if ($request->has('size') && !empty($size)) {
            $products->whereHas('stocks', function($query) use ($size) {
                $query->where('size', '=', $size);
            });
        }

        if ($request->has('order') && !empty($order)) {
            switch ($order) {
                case 'discount':
                    $products->whereHas('stocks', function($query) use ($size) {
                        $query->where('quantity', '>', 0);
                    });
                    $products->where('discount', '>', 0);
                    $products->orderBy('discount', 'desc');

                    break;

                case 'news':

                    $products->orderBy('id', 'desc');
                    break;

                case 'a-z':
                    $products->orderBy('brand', 'asc');
                    $products->orderBy('name', 'asc');

                    break;

                case 'z-a':
                    $products->orderBy('brand', 'desc');
                    $products->orderBy('name', 'desc');

                    break;

                case 'less-price':

                    $products->orderBy('price', 'asc');

                    break;

                case 'more-price':

                    $products->orderBy('price', 'desc');

                    break;

                case 'most-sold':

                    $products->with(['order_items' => function ($q) {
                            $q->select('product_id')->groupBy('product_id')->orderByRaw('SUM(quantity)', 'DESC');
                        }]);

                    break;
            }
        }

        if ($request->has('price-start') && $request->has('price-end') && !empty($price_start) && !empty($price_end)) {
            $products->whereBetween('price', [$price_start, $price_end]);
        }

        $products_all = Product::select('brand')->distinct()->orderBy('brand', 'asc')->get();
        $sizes = Stock::select('size')->distinct()->orderBy('size', 'asc')->get();

        $title = "All our products";
        return view('product.all_for_users', [
            'products' => $products->paginate(12),
            'sizes' => $sizes,
            'products_all' => $products_all,
            'title' => $title
        ]);
    }

    public function categoriesForUser(Request $request, Product $products, $id) {
        $gender = $request->get('gender');
        $child = $request->get('kids');
        $brand = $request->get('brand');
        $size = $request->get('size');
        $order = $request->get('order');
        $price_start = $request->input('price-start');
        $price_end = $request->input('price-end');

        $products = $products->newQuery();

        $category = Category::find($id);

        $products->where('category_id', '=', $id);
        if ($request->has('gender') && !empty($gender)) {
            $products->where('gender', '=', $gender);
        }


        if ($request->has('kids') && !empty($child)) {
            $products->whereHas('childs', function($query) use ($child) {
                $query->where('child', '=', $child);
            });
        } else {
            $products->whereHas('childs', function($query) use ($child) {
                $query->where('child', '=', 0);
            });
        }

        if ($request->has('brand') && !empty($brand)) {
            $products->where('brand', '=', $brand);
        }

        if ($request->has('size') && !empty($size)) {
            $products->whereHas('stocks', function($query) use ($size) {
                $query->where('size', '=', $size);
            });
        }

        if ($request->has('order') && !empty($order)) {
            switch ($order) {
                case 'discount':
                    $products->whereHas('stocks', function($query) use ($size) {
                        $query->where('quantity', '>', 0);
                    });
                    $products->where('discount', '>', 0);
                    $products->orderBy('discount', 'desc');

                    break;

                case 'news':

                    $products->orderBy('id', 'desc');
                    break;

                case 'a-z':
                    $products->orderBy('brand', 'asc');
                    $products->orderBy('name', 'asc');

                    break;

                case 'z-a':
                    $products->orderBy('brand', 'desc');
                    $products->orderBy('name', 'desc');

                    break;

                case 'less-price':

                    $products->orderBy('price', 'asc');

                    break;

                case 'more-price':

                    $products->orderBy('price', 'desc');

                    break;
            }
        }

        if ($request->has('price-start') && $request->has('price-end') && !empty($price_start) && !empty($price_end)) {
            $products->whereBetween('price', [$price_start, $price_end]);
        }

        $products_all = Product::select('brand')->distinct()->orderBy('brand', 'asc')->get();
        $sizes = Stock::select('size')->distinct()->orderBy('size', 'asc')->get();

        $title = "Products for ";
        return view('product.categories_for_user', [
            'products' => $products->paginate(12),
            'sizes' => $sizes,
            'products_all' => $products_all,
            'category' => $category,
            'title' => $title
        ]);
    }

    public function search(Request $request) {

        $search = $request->input('search-in');

        if ($request->has('search-in') && $request != null) {
            $products = Product::where('brand', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%');
        } else {
            return redirect()->route('home');
        }

        return view('product.search', [
            'products' => $products->get()
        ]);
    }

}
