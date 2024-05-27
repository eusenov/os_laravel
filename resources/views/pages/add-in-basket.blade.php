<?php

// if($_COOKIE['isAdmin']){
//     echo "Выйдите из режима администратора, чтобы оформить заказ"; 
// } else {

// }

?>

<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        @if($mess)
            <p>{{ $mess }}</p>
        @else 

        @endif
    </x-slot>
</x-layout>