<?php



?>


<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        @if(isset($mess))
            <p>{{ $mess }}</p>
        @else 
            @auth
                <p>Вы авторизованы как пользователь с ID: {{ auth()->user()->id }}</p> <br>
				<p> Имя товара - {{ $product->name }} </p> 
                <!-- Ваши другие данные и логика для авторизованных пользователей -->
            @else
                <p>Вы не авторизованы. Пожалуйста, войдите в систему, чтобы оформить заказ.</p>
				<a href="{{ url('/login') }}"></a>
                <!-- Логика для неавторизованных пользователей -->
            @endauth
        @endif
    </x-slot>
</x-layout>
