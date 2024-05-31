<x-layout>

    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="wrapper">
            <form method="GET" action="{{ route('catalog') }}" class="filter-form">
                <div class="filter-item">
                    <label for="country">Страна:</label>
                    <input type="text" id="country" name="country" value="">
                </div>
                <div class="filter-item">
                    <label for="name">Название:</label>
                    <input type="text" id="name" name="name" value="">
                </div>
                <div class="filter-item">
                    <label for="color">Цвет:</label>
                    <input type="text" id="color" name="color" value="">
                </div>
                <div class="filter-item">
                    <label for="type">Тип:</label>
                    <input type="text" id="type" name="type" value="">
                </div>
                <button type="submit" class="btn btn-primary">Фильтр</button>
                <a href="{{ route('catalog') }}" class="btn btn-secondary">Сбросить</a>
            </form>
            <div class="container">
                @foreach($products as $product)
                    <div class="product-block">
                        <div class="product-block__up">
                            <div class="product-block__photo">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                </a>
                            </div>
                        </div>
                        <div class="product-block__down">
                            <div class="product-block__name"> 
                                <a href="{{ route('product.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </div>
                            <div class="product-block__price"> {{ $product->price }} руб.</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>
</x-layout>
