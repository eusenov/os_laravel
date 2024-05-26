<?php
function addProduct($image, $name, $price, $in_stock, $category, $created_at)
{

    $link = mysqli_connect('localhost', "root", '', 'laravel-2');
    if($link){echo("<script>console.log('БД подключена');</script>");} else {echo("<script>console.log('БД не подключена');</script>"); mysqli_connect_error(); die("Error"); } 

    $query = "INSERT INTO products (image, name, price, in_stock, category, created_at) VALUE ('$image', '$name', '$price', $in_stock, '$category', '$created_at')";

    if( mysqli_query($link,$query) ) echo "Товар добавлен.";
    else echo "Товар не добавлен:" . mysqli_error($link); echo '<br>'; 
    
    mysqli_close($link); 
    
}


addProduct($image, $name, $price, $in_stock, $category, $created_at);  

?>

<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <div class="reg-container wrapper">
            <div class="reg-container__content">
            </div>
        </div>
    </x-slot>
</x-layout>
