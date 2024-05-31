<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="product-detail wrapper">
            <div class="product-detail__photo">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>
            <div class="product-detail__info">
                <h1>{{ $product->name }}</h1>
                <p>Цена: {{ $product->price }} руб.</p>
                <p>Страна: {{ $product->country }}</p>
                <p>Тип: {{ $product->type }}</p>
                <p>Цвет: {{ $product->color }}</p>
				<!-- <p>id: {{ $product->id }}</p> -->
                <form method="POST" action="{{ route('store.basket') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                </form>
            </div>
        </div>
    </x-slot>
</x-layout>
