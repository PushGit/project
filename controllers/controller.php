<?php 

namespace controller;
use view\first as vFirst;
use model\user as mUser;
use model\products as mProducts;
use model\dateBase as dateBase;
use model\companies as mCompanies;
/*------      куки     ---------  */

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
	public static function set_cookie($var, $n)
	{
		setcookie("$var", $n, time() + 3600*24*30*12, "/");
	}

	public static function unset_cookie($var, $n)
	{
		setcookie("$var", $n, time() - 3600*24*30*12, "/");
	}

	public static function logout()
	{
		main::unset_cookie("userID", $userID);
		main::unset_cookie("log", $_POST["login"]);
		main::unset_cookie("pa", md5($_POST["passw"]));
		header("Location: ".$_SERVER['HTTP_REFERER']); 
	}

	public static function reg()//регистрация
	{
		\view\main::registration();
		if(!empty($_POST['login']) and !empty($_POST['passw'])) 
		{   
			$name = $_POST['login']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM users WHERE name = '$name'");
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
			{
				echo "<form id=text_new>Логин может состоять только из букв английского алфавита и цифр";
			}
			elseif(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
			{
				echo "<form id=text_new>Логин должен быть не меньше 3-х символов и не больше 30";
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Пользователь с таким логином уже существует в базе данных";
			}
			else
			{
				mUser::addUser();
			}
		}
	}

	public static function enter()
	{
		@$nameUser = $_COOKIE['log'];

		if(@$_COOKIE['log']=="")
	    {
	      \view\main::login();
	    }
	    else
	    {
	      \view\main::hello($nameUser);
	      
	    }
	}

	public static function login()
	{	   
		if ((!empty(@$_POST['login']) && (!empty(@$_POST['password']))))
		{ 
			\model\login();//проверка пароля и логина
			//main::view();
		}
	}	
}


class companies
{
	public static function search()
	{
		$nameCompany = @$_POST['nameCompany'];		
		$data = mCompanies::getCompaniesSearch($nameCompany);
		\view\companies::view($data);
	}
	public static function view()
	{
		$nameCompany = @$_POST['nameCompany'];
		$data = mCompanies::getCompanies($nameCompany);
		\view\companies::view($data);
	}
	public static function doneEdit()
	{
		$id=$_COOKIE['companyID'];
		mCompanies::edit($id);
	}
	public static function edit()
	{
		\view\companies::edit();
	}
	public static function delete()
	{
		$id = @$_GET["id"];
		 mCompanies::delete($id);
	}

	public static function insert()
	{
		if(!empty($_POST['nameCompany'])) 
		{  
		  //проверка нет ли уже такой компании
			$nameCompany = $_POST['nameCompany']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM companies WHERE name = '$nameCompany'") or die(mysqli_error());
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['nameCompany']))
			{
				echo "<form id=text_new>Название может состоять только из букв английского алфавита и цифр";
			}
			elseif(strlen($_POST['nameCompany']) < 3 or strlen($_POST['nameCompany']) > 30)
			{
				echo "<form id=text_new>Название должно быть не меньше 3-х символов и не больше 30";
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Компания с таким названием уже существует, придумайте другое";
			}
			else
			{
				mCompanies::insert();
			}
		}
		else{
			echo "<form id=text_new>Введите данные";
		}
	}
}

class products
{
	public static function view()
	{
		$id = @$_GET["id"];
		$data = mProducts::getProducts();
		if($id==$_COOKIE['companyID'])
		{
			\view\products::view($data);
		}
		else
		{
			\view\products::viewOther($data);
		}
	}
	public static function search()
	{
		$id = @$_GET["id"];
		$nameProduct=$_POST["nameProduct"];
		$data = mProducts::search($nameProduct);
		if($id==$_COOKIE['companyID'])
		{
			\view\products::view($data);
		}
		else
		{
			\view\products::viewOther($data);
		}
	}
	public static function qDelete()//вы уверены что хотите удалить?
	{
		\view\products::delete();
	}
	public static function delete()//если да
	{
		mProducts::delete();
		\view\products::doneDelete();
	}
	public static function edit()//отображаем форму редактирования
	{
		\view\products::edit();
	}
	public static function doneEdit()//редактируем
	{
		mProducts::edit();
		\view\products::doneEdit();
	}
	public static function doneInsert()
	{
		if(!empty($_POST['nameProduct'])) 
		{  
			$nameProduct = $_POST['nameProduct']; 
			$price = $_POST['price']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM products WHERE name = '$nameProduct'");
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			
			if(!preg_match("/^[a-z A-Z 0-9]+$/",$_POST['nameProduct']))
			{
				echo "<form id=text_new>Название может состоять только из букв английского алфавита и цифр</form>
				<form method=post action=index.php?page=products&action=insert> 
				<br><input class=button type=submit id='button_new' value=Назад>
				</form>";
			}
			elseif(!preg_match("/^[0-9]+$/",$_POST['price']))
			{
				echo "<form id=text_new>Цена может состоять только цифр<br></form>
				<form method=post action=index.php?page=products&action=insert> 
				<br><input class=button type=submit id='button_new' value=Назад>
				</form>";
			}
			elseif(strlen($_POST['nameProduct']) < 3 or strlen($_POST['nameProduct']) > 30)
			{
				echo "<form id=text_new>Название должно быть не меньше 3-х символов и не больше 30</form>
				<form method=post action=index.php?page=products&action=insert> 
				<br><input class=button type=submit id='button_new' value=Назад>
				</form>";
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Продукт с таким названием уже существует, придумайте другое</form>
				<form method=post action=index.php?page=products&action=insert> 
				<br><input class=button type=submit id='button_new' value=Назад>
				</form>";
			}
			else
			{
				mProducts::insert();
				\view\products::doneInsert();
			}
		}
	}
	public static function insert()
	{
		\view\products::insert();
	}
}

function controller_pages_products()
	{
		echo "<div class=\"pages\">";
		if (empty($_GET['p']))
			{
			  $_GET['p'] = 1;
			}
		$p = $_GET['p'];
		$companyID = $_GET['id'];
		if(!empty($_GET['nameProduct']))
		{
			$nameProduct = @$_GET['nameProduct'];
		}
		else
		{
			$nameProduct = @$_POST['nameProduct'];
		}
		
		$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = '$companyID' AND name LIKE '%$nameProduct%'"));
		$num_on_page = 10;
		$pages = ceil($max_items/$num_on_page);
		for ($i=1; $i<=$pages; $i++)
		 {
			if(!empty($_GET['nameProduct']))
			{
				$nameProduct = @$_GET['nameProduct'];
			}
			else
			{
				$nameProduct = @$_POST['nameProduct'];
			}
			 if ($i!=$p) 
			 {
			 	if($nameProduct == null)
			 	{
			 		echo "<form id=text_new><a href=\"index.php?page=products&action=view&id={$companyID}&p={$i}\">{$i}</a>";
			 	}
			 	else
			 	{
			 		echo "<form id=text_new><a href=\"index.php?page=products&action=view&id={$companyID}&nameProduct=$nameProduct&p={$i}\">{$i}</a>";
			 	}
			 }
			 else echo "<form id=text_new><b>{$i}</b>";
		 }
		echo "</div>";
		dateBase::close_bd();
	}

function controller_pages($page)
{
 	$id=@$_GET['id'];
	echo "<div class=pages>";
	if (empty($_GET['p']))
		{
		  $_GET['p'] = 1;
		}
	$p = $_GET['p'];
	
		if(!empty($_GET['nameCompany']))
		{
			$nameCompany = @$_GET['nameCompany'];
		}
		else
		{
			$nameCompany = @$_POST['nameCompany'];
		}

		$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE name LIKE '%$nameCompany%'"));
	 $num_on_page = 10;
	 $pages = ceil($max_items/$num_on_page);
	 for ($i=1; $i<=$pages; $i++)
	 {
		if ($i!=$p) 
		{
			if(!empty($_GET['nameCompany']))
			{
				$nameCompany = @$_GET['nameCompany'];
			}
			else
			{
				$nameCompany = @$_POST['nameCompany'];
			}
			if($nameCompany == null)
			 	{
			 		echo "<form id=text_new><a href=index.php?page=companies&action=view&p={$i}>{$i}</a>";
			 	}
			 	else
			 	{
			 		echo "<form id=text_new><a href=index.php?page=companies&action=view&nameCompany=$nameCompany&p={$i}>{$i}</a>";
			 	}
			
		}
		else echo "<form id=text_new><b>{$i}</b>";
		
	 }
	echo "</div>";
	dateBase::close_bd();
}
?>