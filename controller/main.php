<?php 

namespace controller;
use model\user as mUser;
use model\dateBase as dateBase;
use view\products as vProducts;
use view\companies as vCompanies;
use model\products as mProducts;
use model\companies as mCompanies;

class main
{
	public static function view()
	{
		if ((empty($_COOKIE['log'])) && (empty($_COOKIE['pa'])))
		{ 
			echo "<form id=text_new>Зарегистрируйтесь или войдите под своей учетной записью</a></form>";
		}
		else 
		{
			mUser::checkUser();
		}
	}
	public static function login()
	{	   
		if ((!empty(@$_POST['login']) && (!empty(@$_POST['password']))))
		{ 
			mUser::login();
		}
		else
		{
			mUser::reg();
		}
	}	
	public static function logout()
	{	   
		mUser::logout();
	}	
	public static function reg()
	{	   
		mUser::reg();
	}	
}
?>