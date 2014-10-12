<?php
namespace model;
use view as view;
use view\main as vMain;
use view\companies as vCompanies;
use view\products as vProducts;

class main
{
	public static function set_cookie($var, $n)
	{
		setcookie("$var", $n, time() + 3600*24*30*12, "/");
	}

	public static function unset_cookie($var, $n)
	{
		setcookie("$var", $n, time() - 3600*24*30*12, "/");
	}

	public static function enter()
	{
		@$nameUser = $_COOKIE['log'];

		if(@$_COOKIE['log']=="")
	    {
	      vMain::login();
	    }
	    else
	    {
	      vMain::hello($nameUser);
	      
	    }
	}

	public static function have()//проверка есть ли продукты у нашей компании
	{
		$id = @$_COOKIE['companyID'];
		$result1 = mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = '$id'" );
		$prod="";
		while ($rslt1 = mysqli_fetch_row($result1)) 
		{ 
			$prod = $rslt1[1];
		}
		dateBase::close_bd();
		return $prod;
	}
}
?>