<?php

// if($mess == 'isAdmin'){
//     setcookie("isAdmin", true, time() + 86400, "/");
// } else {
//     setcookie("isAdmin", "", time() - 3600, "/");
// }
?>

<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        @if( $mess == 'isAdmin' )
            <div class="admin-div">
                <div class="admin-div__content wrapper">
                    <h1>Админ-панель</h1>
                    <div class="admin-div__columns">
                        <div class="admin-div__column">
                            <h3>Товары</h3>
                            <a href="">Добавить</a>
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
                </div>
            </div>
        @else
        
        @endif
    </x-slot>
</x-layout>




