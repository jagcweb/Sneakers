<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except('getImage');
        $this->middleware('admin')->except('getImage');
    }

    public function index() {
        return view('category.index');
    }

    public function create() {
        return view('category.create');
    }

    public function save(Request $request) {
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'image' => ['required', 'image']
        ]);

        $name = $request->input('name');
        $image = $request->file('image');

        $category = new Category();
        $category->name = $name;

        if ($image != null) {

            $image_name = time() . $image->getClientOriginalName();

            $category->image = $image_name;

            \Storage::disk('categories')->put($image_name, \File::get($image));
        } else {
            return redirect()->route('category.create')->with(['message' => 'Error creating category']);
        }

        $category->save();

        return redirect()->route('category.all')->with(['message' => 'Category created successfully']);
    }

    public function getAll() {
        $categories = Category::orderBy('id', 'desc')->get();;

        return view('category.all', [
            'categories' => $categories
        ]);
    }

    public function delete($id) {
        $category = Category::find($id);

        if (\Auth::user()->role == 'admin') {
            $category->products()->delete();
            $category->delete();
            session()->now('message', 'Categoría borrada!');
        } else {
            session()->now('message', 'Error al borrar la categoria');
        }
        return redirect()->route('category.all')->with(['message' => 'Category deleted successfully']);
    }

    public function edit($id) {
        $category = Category::find($id);

        return view('category.edit', [
            'category' => $category
        ]);
    }

    public function update($id, Request $request) {

        $validate = $this->validate($request, [
            'name' => ['string', 'max:50']
        ]);
        $categoria_name = $request->input('name');
        $image = $request->file('image');

        $categoria = Category::find($id);

        if ($categoria) {
            $categoria->name = $categoria_name;
            if ($image != null) {
                $validate = $this->validate($request, [
                    'image' => ['image']
                ]);

                \Storage::disk('products')->delete($categoria->image);


                $image_name = time() . $image->getClientOriginalName();

                $categoria->image = $image_name;

                \Storage::disk('categories')->put($image_name, \File::get($image));
            }
            $categoria->update();
        }
        return redirect()->route('category.all')->with(['message' => 'Updated category!']);
    }

    public function getImage($filename) {
        $file = \Storage::disk('categories')->get($filename);

        return new Response($file, 200);
    }

}
