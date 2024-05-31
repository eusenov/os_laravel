<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="wrapper">
            <h1>Корзина</h1>
            @if($products->isEmpty())
                <p>Ваша корзина пуста.</p>
            @else
				<div>
					@foreach($products as $product)
						<div class="basket-item">
							<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="basket-item__image">
							<div class="basket-item__details">
								<h2>{{ $product->name }}</h2>
								<p>Цена за единицу: {{ $product->price }} руб.</p>
								<div class="basket-item__actions">
									<form action="{{ route('basket.update', ['id' => $product->id, 'action' => 'decrease']) }}" method="POST">
										@csrf
										<button type="submit" class="btn">-</button>
									</form>
									<span class="quantity">{{ $product->quantity }}</span>
									<form action="{{ route('basket.update', ['id' => $product->id, 'action' => 'increase']) }}" method="POST">
										@csrf
										<button type="submit" class="btn">+</button>
									</form>
								</div>
								<p>Общая стоимость: {{ $product->price * $product->quantity }} руб.</p>
								<form action="{{ route('basket.remove', ['id' => $product->id]) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn">Удалить</button>
								</form>
							</div>
						</div>
					@endforeach
				</div>
				<!-- <div>
					<form method="POST" action="{{ route('place.order') }}">
						@csrf
						<button type="submit" class="btn btn-primary">Заказать</button>
					</form>
				</div> -->
            @endif
        </div>
    </x-slot>
</x-layout>
