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
    public function store_in_basket(Request $request)
    {
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
        } else if (isset($_COOKIE['isAdmin']) && $_COOKIE['isAdmin']){
			return redirect()->route('login')->with('error', 'Пожалуйста, выйдите из режима админа и войдите как клиент, чтобы добавить товар в корзину');
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
	
	// admin products

	public function adminProducts()
	{
		$products = DB::table('products')->get();
		return view('admin.products', ['title' => 'Admin Products', 'products' => $products]);
	}

	public function editProductForm($id)
	{
		$product = DB::table('products')->find($id);
		if (!$product) {
			abort(404);
		}
		return view('admin.red-product', ['title' => 'Edit Product', 'product' => $product]);
	}

	public function updateProduct(ProductRequest $req, $id)
	{
		$data = $req->validated();
		$currentTimestamp = Carbon::now();
		
		$updateData = [
			'name' => $data['name'],
			'price' => $data['price'],
			'in_stock' => $data['in_stock'],
			'type' => $data['type'],
			'color' => $data['color'],
			'country' => $data['country'],
			'updated_at' => $currentTimestamp,
		];

		if ($req->hasFile('image')) {
			$path = $req->file('image')->store('images', 'public');
			$updateData['image'] = $path;
		}

		DB::table('products')->where('id', $id)->update($updateData);
		return redirect()->route('admin.products')->with('success', 'Product updated successfully');
	}

	public function deleteProduct($id)
	{
		DB::table('products')->where('id', $id)->delete();
		return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
	}

	
	// orders 
	public function orders()
    {
        $userId = auth()->user()->id;

        $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->get();

        return view('pages.orders', [
            'title' => 'Orders',
            'orders' => $orders,
        ]);
    }

	public function placeOrder()
    {
        $userId = auth()->user()->id;
        $timestamp = Carbon::now()->format('Y_m_d_His');
        $tableName = "user_{$userId}_{$timestamp}";

        // Создание записи в таблице orders
        DB::table('orders')->insert([
            'user_id' => $userId,
            'created_at' => Carbon::now(),
            'status' => 'pending',
        ]);

        // Создание таблицы для нового заказа
        $this->createOrderTable($userId, $timestamp);

        // Перемещение товаров из корзины в таблицу заказа
        $basketItems = DB::table('basket')->where('userID', $userId)->get();
        foreach ($basketItems as $item) {
            DB::table($tableName)->insert([
                'product_id' => $item->productID,
                'quantity' => $item->quantity,
                'status' => 'in_order',
            ]);
            DB::table('products')->where('id', $item->productID)->decrement('in_stock', $item->quantity);
        }

        // Очистка корзины
        DB::table('basket')->where('userID', $userId)->delete();

        return redirect()->route('orders')->with('success', 'Заказ успешно оформлен');
    }

    public function createOrderTable($userId, $timestamp)
    {
        $tableName = "user_{$userId}_{$timestamp}";
        
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->string('status')->default('in_order');
        });
    }

    public function deleteOrder($id)
    {
        $userId = auth()->user()->id;
        $order = DB::table('orders')->where('id', $id)->where('user_id', $userId)->first();

        if ($order) {
            $tableName = "user_{$order->user_id}_{$order->created_at->format('Y_m_d_His')}";

            // Восстановление количества товаров в наличии
            $orderItems = DB::table($tableName)->get();
            foreach ($orderItems as $item) {
                DB::table('products')->where('id', $item->product_id)->increment('in_stock', $item->quantity);
            }

            // Удаление таблицы заказа
            Schema::dropIfExists($tableName);

            // Удаление записи о заказе
            DB::table('orders')->where('id', $id)->delete();
        }

        return redirect()->route('orders')->with('success', 'Заказ удален');
    }
}



