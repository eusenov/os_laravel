<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use App\Http\Requests;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\ProductRequest;
use BadFunctionCallException;
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Database\Schema\Blueprint;

class PagesController extends Controller
{
	public function catalog(Request $request)
	{
		$query = DB::table('products');

		if ($request->has('country') && $request->country != '') {
			$query->where('country', $request->country);
		}

		if ($request->has('name') && $request->name != '') {
			$query->where('name', 'like', '%' . $request->name . '%');
		}

		if ($request->has('color') && $request->color != '') {
			$query->where('color', $request->color);
		}

		if ($request->has('type') && $request->type != '') {
			$query->where('type', $request->type);
		}

		$products = $query->get();

		return view('pages.catalog', ['title' => 'catalog', 'products' => $products]);
	}


    public function admin_login()
    {
        return view('pages.admin-login', ['title'=>'admin_login']); 
    }
    public function admin_val(AdminRequest $req)
    {
        $data = $req->validated();

        $user = DB::table('admin')->where('name', $data['adminLogin'])->first();

        if ( $user && Hash::check($data['adminPass'], $user->password) && !isset($_COOKIE['isAdmin']) ) {
			setcookie("isAdmin", true, time() + 86400, "/");
			return redirect()->route('admin');
        } else {
			return redirect()->route('catalog');
        }

        if (isset($_COOKIE['isAdmin'])){
            return redirect()->route('admin');
        }
    }
	public function admin()
	{
		if (isset($_COOKIE['isAdmin'])){
            return view('pages.admin', ['title'=>'admin']); 
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
    public function store_in_basket(Request $request)
    {
		
		if (isset($_COOKIE['isAdmin'])) {
            return redirect()->route('login')->with('error', 'Пожалуйста, выйдите из режима админа и войдите как клиент, чтобы добавить товар в корзину');
        }
		
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $productId = $request->input('product_id');

            DB::table('basket')->insert([
                'userID' => $userId,
                'productID' => $productId,
				'status' => 'in_basket',
                'quantity' => 1,
            ]);
			
			DB::table('products')
				->where('id', $productId)
				->decrement('in_stock');

            return redirect()->route('catalog')->with('success', 'Товар добавлен в корзину');
        } else {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему, чтобы добавить товар в корзину');
        }
    }
	public function basket()
	{
		$userId = auth()->user()->id;

		$basketItems = DB::table('basket')
			->where('userID', $userId)
			->get();

		$products = $basketItems->map(function ($item) {
			$product = DB::table('products')->find($item->productID);
			$product->quantity = $item->quantity;
			return $product;
		});

		return view('pages.basket', [
			'title' => 'Basket',
			'products' => $products
		]);
	}

	
	public function updateBasket($id, $action)
	{
		$userId = auth()->user()->id;
		$basketItem = DB::table('basket')->where('userID', $userId)->where('productID', $id)->first();
		$product = DB::table('products')->find($id);

		if ($basketItem && $product) {
			if ($action == 'increase' && $product->in_stock > 0) {
				DB::table('basket')
					->where('userID', $userId)
					->where('productID', $id)
					->increment('quantity');
				DB::table('products')
					->where('id', $id)
					->decrement('in_stock');
			} elseif ($action == 'decrease' && $basketItem->quantity > 1) {
				DB::table('basket')
					->where('userID', $userId)
					->where('productID', $id)
					->decrement('quantity');
				DB::table('products')
					->where('id', $id)
					->increment('in_stock');
			}
		}

		return redirect()->route('basket');
	}

	public function removeFromBasket($id)
	{
		$userId = auth()->user()->id;
		$basketItem = DB::table('basket')->where('userID', $userId)->where('productID', $id)->first();

		if ($basketItem) {
			// Восстановление количества товара в наличии
			DB::table('products')
				->where('id', $id)
				->increment('in_stock', $basketItem->quantity);

			// Удаление товара из корзины
			DB::table('basket')
				->where('userID', $userId)
				->where('productID', $id)
				->delete();
		}

		return redirect()->route('basket');
	}
	
}