<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\ProductRequest;
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

    // registr and login
    public function reg()
    {
        return view('pages.reg', ['title'=>'reg']); 
    }
    public function registration(RegRequest $req)
    {
        $data = $req->validated();

        return DB::table('users')->insert([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'] ?? null,
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => $data['password']
        ]); 
    }
    public function login()
    {
        return view('pages.login', ['title'=>'login']); 
    }
}

