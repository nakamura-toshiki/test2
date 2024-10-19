<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::Paginate(6);
        return view('index', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::orderBy('created_at', 'asc')->where(function ($query) {
            if ($keyword = request('keyword')) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            }
        })->paginate(6);

        $keyword = $request->keyword;
        if (empty($keyword)) {
            return redirect('/products');
        }

        return view('search', compact('products', 'keyword'));

    }

    public function show(Request $request)
    {
        $product = Product::find($request->id);
        return view('show', compact('product'));
    }


}
