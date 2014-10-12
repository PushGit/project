<?php
namespace view;
use model\dateBase as dateBase;
class main
{
	public static function login()
	{
		echo "<form method=post action=index.php?page=main&action=login class=login>";
	    echo "<input type=text required name=login placeholder='Login' id=search_box value=>";
	    echo "<p>";
	    echo "<input type=password required name=password placeholder='Password' id=search_box value=>";
	    echo "</p>";
	   
	    echo "<button type=submit id=button_new >Войти</button>";
	    echo "</form> ";

	    echo "<form method=post action=index.php?page=main&action=reg class=login>";
	    echo "<button type=submit id=button_new class = registration>Зарегистрироваться</button>";
	  	echo "</form>";
	}

	public static function hello($nameUser)
	{
		echo "<form method=post action=index.php?page=main&action=logout class=hello>";
		echo "Привет, $nameUser!";
		echo "<input type=submit id='button_new' value=Выход />";
		echo "</form>";
	}
	
	public static function doneReg()
	{
		echo "<form id=text_new>Пользователь добавлен</form>
			<form method=post action=index.php> 
			<input class=button type=submit id=button_new value=ОК>";
	}

	public static function registration()
	{
		echo "<form id=text_new>Добавить пользователя</form>
		<form method=post id=text_new> Логин <br>
		<input class=input required placeholder='Введите логин' id=search_box name=login value=>  
		<br><br> Пароль <br>
		<input required placeholder='Введите пароль' class=input id=search_box  name=passw value=> 
		<input type=hidden name=enter value=yes> 
		<br><br><button type=submit id=button_new>Зарегистрироваться</button>
		</form>";
	}
}
?>