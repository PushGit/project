<?php
namespace model;
use view as view;
use view\main as vMain;
use view\companies as vCompanies;
use view\products as vProducts;

class user
{
	public static function addUser()//добавление пользователя
	{
		$pas = md5(trim($_POST['passw']));
		$log = trim($_POST['login']);
		mysqli_query(dateBase::connect(), "INSERT INTO companies.users (name,pass) VALUES ('$log', '$pas')");
	    dateBase::close_bd();
	}

	public static function reg()//регистрация
	{
		if(!empty($_POST['login']) and !empty($_POST['passw'])) 
		{   
			$name = $_POST['login']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM users WHERE name = '$name'");
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
			{
				echo "<form id=text_new>Логин может состоять только из букв английского алфавита и цифр<br>";
				vMain::registration();
			}
			elseif(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
			{
				echo "<form id=text_new>Логин должен быть не меньше 3-х символов и не больше 30<br>";
				vMain::registration();
			}
			elseif(strlen($_POST['passw']) < 3 or strlen($_POST['passw']) > 30)
			{
				echo "<form id=text_new>Пароль должен быть не меньше 3-х символов и не больше 30<br>";
				vMain::registration();
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Пользователь с таким логином уже существует в базе данных<br>";
				vMain::registration();
			}
			else
			{
				user::addUser();
				vMain::doneReg();
			}
		}
		else
		{
			vMain::registration();
		}
	}

	public static function login()
	{

		$login = @$_POST['login'];
		$pass = md5(@$_POST['password']);

		$user="";
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM users WHERE name = '$login' AND pass = '$pass'");
		
		while ($rslt = mysqli_fetch_row($result)) 
		{ 
			$user = $rslt[0]; 
		}
		dateBase::close_bd();
		if($user=="")
		{
			echo "<form id=text_new action=index.php>Не верный логин или пароль! Попробуйте ещё раз!</form>";
		}
		else
		{
			$nameUser = $_COOKIE['log'];
			$userID = "";
			$companyID = "";
			$result = mysqli_query(dateBase::connect(), "SELECT id FROM users WHERE name = '$login'");
			while ($rslt = mysqli_fetch_row($result)) 
			{ 
				$userID = $rslt[0]; 
			}
				
			$result = mysqli_query(dateBase::connect(), "SELECT id FROM companies WHERE userID = '$userID'");
			while ($rslt = mysqli_fetch_row($result)) 
			{ 
				$companyID = $rslt[0]; 
			}
			dateBase::close_bd();
			
			main::set_cookie("companyID", $companyID);
			main::set_cookie("userID", $userID);
			main::set_cookie("log", $_POST["login"]);
			main::set_cookie("pa", md5($_POST["passw"]));
			//header("Location: index.php"); 
		}
	}
	public static function logout()
	{
		main::unset_cookie("userID", $userID);
		main::unset_cookie("log", $_POST["login"]);
		main::unset_cookie("pa", md5($_POST["passw"]));
		header("Location: index.php"); 
	}
	public static function checkUser()
	{
		$nameUser = $_COOKIE['log'];
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM users WHERE name = '$nameUser'");
			$id = 0; 
			while ($rslt = mysqli_fetch_row($result)) 
			{ 
				$id = $rslt[0]; 
			}
		
		$result1 = mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE userID = '$id'" );
			$nameCompany="";
		while ($rslt1 = mysqli_fetch_row($result1)) 
		{ 
			$nameCompany = $rslt1[1];
			$a = $rslt1[2];
			$p = $rslt1[3];
		}
		dateBase::close_bd();
		if($nameCompany==null) 
		{
			echo "<form id=text_new><h2>У вас нет компании</h2></form>";
			view\companies::insert();
		}
		else
		{
			echo "<form id=text_new><h2>Наша компания: $nameCompany </h2></form>";
			\view\companies::myCompany();
		}
	}
}
?>