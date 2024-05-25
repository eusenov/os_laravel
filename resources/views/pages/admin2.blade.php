<?php

if($mess == 'isAdmin'){
    setcookie("isAdmin", true, time() + 86400, "/");
} else {
    setcookie("isAdmin", "", time() - 3600, "/");
}

?>
<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        
    </x-slot>
</x-layout>


