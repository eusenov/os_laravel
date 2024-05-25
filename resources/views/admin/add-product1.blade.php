<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <div class="reg-container wrapper">
            <div class="reg-container__content">
                <form class="regForm" method="post" action="{{ url('/add-product2') }}">
                    @csrf
                    <input name="name" placeholder="name" type="text">
                    <input name="price" placeholder="price" type="number">
                    <input name="in_stock" placeholder="in_stock" type="number">
                    <input name="category" placeholder="category" type="text">
                    <input type="submit" value="Добавить">
                </form>
            </div>
        </div>
    </x-slot>
</x-layout>
