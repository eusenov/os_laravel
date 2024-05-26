<x-layout>

    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="container wrapper">
            @foreach($products as $product)
                <div class="product-block">
                    <div class="product-block__up">
                        <div class="product-block__photo">
                            <!-- <img src="img/1.jpeg" alt=""> -->
                        </div>
                    </div>
                    <div class="product-block__down">
                        <div class="product-block__name"> {{ $product->name }} </div>
                        <div class="product-block__price"> {{ $product->price }} руб.</div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-slot>
</x-layout>