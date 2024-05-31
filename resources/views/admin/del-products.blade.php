<x-layout>

    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="wrapper">
            <div class="container">
                <h1>Удалить товар</h1>
                <form method="POST" action="{{ route('admin.products.delete', $product->id) }}">
                    @csrf
                    @method('DELETE')
                    <p>Вы уверены, что хотите удалить товар {{ $product->name }}?</p>
                    <button type="submit" class="btn btn-danger">Удалить</button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </x-slot>
</x-layout>
