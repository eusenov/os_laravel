<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\ProductRequest;
use BadFunctionCallException;
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon;

class PagesController extends Controller
{
    public function catalog()
    {
        $products = DB::table('products')->get();
        return view('pages.catalog', ['title'=>'catalog', 'products'=>$products]); 
    }
    public function admin1()
    {
        return view('pages.admin1', ['title'=>'admin1']); 
    }
    public function admin2(AdminRequest $req)
    {
        $data = $req->validated();

        $user = DB::table('admin')->where('name', $data['adminLogin'])->first();

        // return view('pages.admin2', ['title'=>'admin2', 'mess'=>'111']);

        if ($user && Hash::check($data['adminPass'], $user->password)) {
            return view('pages.admin2', ['title'=>'admin2', 'mess'=>'isAdmin']);
        } else {
            return view('pages.admin2', ['title'=>'admin2', 'mess'=>'isNotAdmin']);
        }

        if (isset($_COOKIE['isAdmin']) && $_COOKIE['isAdmin']){
            return view('pages.admin2', ['title'=>'admin2', 'mess'=>'isAdmin']);
        }
    }
    public function admin_logout()
    {
        setcookie("isAdmin", "", time() - 3600, "/");
        return redirect()->route('catalog');
    }
    public function add_product1()
    {
        return view('admin.add-product1', ['title'=>'add product 1']); 
    }
    public function add_product2(ProductRequest $req)
    {
        $currentTimestamp = Carbon::now();
        $data = $req->validated();
        $path = $req->file('image')->store('images', 'public');

        DB::table('products')->insert([
            'name' => $data['name'],
            'price' => $data['price'],
            'in_stock' => $data['in_stock'],
            'type' => $data['type'],
            'color' => $data['color'],
            'country' => $data['country'],
            'created_at' => $currentTimestamp,
            'image' => $path,
        ]);

        return redirect('/add-product1');
    }
    public function productPage($id)
    {
        $product = DB::table('products')->find($id);
        if (!$product) {
            abort(404);
        }
        return view('pages.product', ['title' => $product->name, 'product' => $product]);
    }
    public function add_in_basket($id)
    {
        if (isset($_COOKIE['isAdmin']) && $_COOKIE['isAdmin']) {
            $message = "Выйдите из режима администратора, чтобы оформить заказ"; 
            return view('pages.add-in-basket', ['title' => 'Basket', 'id' => $id, 'mess'=>$message]);
        } else {
			$product = DB::table('products')->where('id', $id)->first();
            return view('pages.add-in-basket', ['title' => 'Basket', 'product' => $product]);
        }

    }
}

