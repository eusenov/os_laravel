<x-layout>

    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        <div class="wrapper">
            <div class="container">
                <h1>Редактировать товар</h1>
                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="in_stock">В наличии</label>
                        <input type="number" class="form-control" id="in_stock" name="in_stock" value="{{ $product->in_stock }}" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Тип</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ $product->type }}" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Цвет</label>
                        <input type="text" class="form-control" id="color" name="color" value="{{ $product->color }}" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Страна</label>
                        <input type="text" class="form-control" id="country" name="country" value="{{ $product->country }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Изображение</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </x-slot>
</x-layout>
