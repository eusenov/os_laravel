<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="wrapper">
            <h1>Мои заказы</h1>
            @if($orders->isEmpty())
                <p>У вас нет заказов.</p>
            @else
                @foreach($orders as $order)
                    <div class="order-item">
                        <h2>Заказ от {{ $order->created_at }}</h2>
                        @php
                            $tableName = "user_{$order->user_id}_{$order->created_at->format('Y_m_d_His')}";
                            $orderItems = DB::table($tableName)->get();
                            $totalCost = 0;
                        @endphp
                        <ul>
                            @foreach($orderItems as $item)
                                @php
                                    $product = DB::table('products')->where('id', $item->product_id)->first();
                                    $totalCost += $product->price * $item->quantity;
                                @endphp
                                <li>{{ $product->name }} - {{ $item->quantity }} шт. - {{ $product->price * $item->quantity }} руб.</li>
                            @endforeach
                        </ul>
                        <p>Общая стоимость: {{ $totalCost }} руб.</p>
                        <form method="POST" action="{{ route('order.delete', $order->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить заказ</button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </x-slot>
</x-layout>
