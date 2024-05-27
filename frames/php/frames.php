<?php
function addProduct($name, $price, $in_stock, $type, $color, $country, $created_at, $image)
{

    $link = mysqli_connect('localhost', "root", '', 'laravel-2');
    if($link){echo("<script>console.log('БД подключена');</script>");} else {echo("<script>console.log('БД не подключена');</script>"); mysqli_connect_error(); die("Error"); } 

    $query = 
    "INSERT INTO products (image, name, price, in_stock, category, created_at) 
    VALUE ('$name', $price, $in_stock, '$type', '$color', '$country', '$created_at', '$image')";

    if( mysqli_query($link,$query) ) echo "Товар добавлен.";
    else echo "Товар не добавлен:" . mysqli_error($link); echo '<br>'; 
    
    mysqli_close($link); 
    
}


// addProduct($name, $price, $in_stock, $type, $color, $country, $created_at, $image);  

////////////////////////////////////////////////////////////////////////


    // registr and login
    public function reg()
    {
        return view('pages.reg', ['title'=>'reg']); 
    }
    public function registration(RegRequest $req)
    {
        $data = $req->validated();

        return DB::table('users')->insert([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'] ?? null,
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => $data['password']
        ]); 
    }
    public function login()
    {
        return view('pages.login', ['title'=>'login']); 
    }

?>