<?php

include '../functions/functions.php';
include "../functions/connect.php";

if ($_POST['label']=='register_new_user'){ 
  $err = [];
      // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM deficit_users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "login_have";//Пользователь с таким логином уже существует в базе данных
        echo $err[0];
    }

     if(count($err) == 0)
    {

        $login = $_POST['login'];
        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link,"INSERT INTO deficit_users SET user_login='".$login."', user_password='".$password."'");
        echo "saved";
    }

}

if ($_POST['label']=='enter_log_pass'){
	  $login=$_POST['login'];
	   $password=$_POST['password'];

	   // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM deficit_users WHERE user_login='".mysqli_real_escape_string($link,$login)."' LIMIT 1");
    
    $data = mysqli_fetch_assoc($query);
    
    // Сравниваем пароли
    if($data['user_password'] === md5(md5($password))) {
    	//echo "пароли совпали";

    	  // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        // Записываем в БД новый хеш авторизации и IP
        @mysqli_query($link, "UPDATE deficit_users SET user_hash='".$hash."' "." WHERE user_id='".$data['user_id']."'");
           echo $hash;//  пошло на запись в localstorage

    }
}

?>