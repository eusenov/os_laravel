

<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
		<div class="admin-div">
			<div class="admin-div__content wrapper">
				<h1>Админ-панель</h1>
				<div class="admin-div__columns">
					<div class="admin-div__column">
						<h3>Товары</h3>
						<a href="{{ route('add.product') }}">Добавить</a>
						<a href="">Удалить</a>
						<a href="">Редактировать</a>
					</div>
					<div class="admin-div__column">
						<h3>Категории</h3>
						<a href="">Добавить</a>
						<a href="">Удалить</a>
					</div>
					<div class="admin-div__column">
						<h3>Заказы</h3>
						<a href="">На страницу заказов</a>
					</div>
				</div>
				<div>
					<a href="{{ route('admin.logout') }}">Выйти из режима Админа</a>
				</div>
			</div>
		</div>
    </x-slot>
</x-layout>




