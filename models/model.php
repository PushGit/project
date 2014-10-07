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


class dateBase
{
	public static function connect()
	{
		$link  = mysqli_connect('localhost', 'root', '435123451', 'companies');
			if (!$link) {
			die('Ошибка соединения: ' . mysqli_error());
		}
		return $link;
	}

	public static function close_bd()
	{
		mysqli_close(dateBase::connect());
	}
}

class companies
{	
	public static function delete()
	{
		if(isset($_POST['delete']))
		{
			$id=$_COOKIE['companyID'];
			mysqli_query(dateBase::connect(), "DELETE FROM companies WHERE id=$id") or die(mysqli_error(dateBase::connect())); 
			dateBase::close_bd();
			main::unset_cookie("companyID","0");
			vCompanies::doneDelete();
		}
		else
		{
			vCompanies::delete();
		}
	}
	public static function edit()//редактирование компании
	{
		if(isset($_POST['edit']))
		{
			$id=$_COOKIE['companyID'];
			$newadress = $_POST['newadress'];
			$newphone = $_POST['newphone'];
			$newnameCompany = $_POST['newnameCompany'];
			mysqli_query(dateBase::connect(), "UPDATE companies SET name = '$newnameCompany', adress = '$newadress', phone = '$newphone' WHERE id = '$id'");
		    dateBase::close_bd();
		    vCompanies::doneEdit();
		}
		else
		{
			vCompanies::edit();
		}
	}

	public static function insert()//добавление компании
	{
		if(isset($_POST['insert']))
		{
			$nameCompany = $_POST['nameCompany']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM companies WHERE nameCompany = '$nameCompany'") or die(mysqli_error());
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['nameCompany']))
			{
				echo "<form id=text_new>Название может состоять только из букв английского алфавита и цифр<br>";
				vCompanies::insert();
			}
			elseif(strlen($_POST['nameCompany']) < 3 or strlen($_POST['nameCompany']) > 30)
			{
				echo "<form id=text_new>Название должно быть не меньше 3-х символов и не больше 30<br>";
				vCompanies::insert();
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Компания с таким названием уже существует, придумайте другое<br>";
				vCompanies::insert();
			}
			else
			{
				$nameUser = $_COOKIE['log'];
				$result = mysqli_query(dateBase::connect(), "SELECT * FROM users WHERE name = '$nameUser'");
				while ($rslt = mysqli_fetch_row($result)) 
				{ 
					$id = $rslt[0]; 
				}
				$name = $_POST['nameCompany'];
				$adress = $_POST['adress'];
				$phone = $_POST['phone'];
				dateBase::close_bd();

				mysqli_query(dateBase::connect(), "INSERT INTO companies (name, adress, phone, userID) VALUES ('$name','$adress', '$phone', '$id')") or die(mysqli_error(dateBase::connect()));
			   
			    $result = mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE nameCompany = '$name'");
				while ($rslt = mysqli_fetch_row($result)) 
				{ 
					$newID = $rslt[0]; 
				}
				main::set_cookie("companyID","$newID");
				dateBase::close_bd();
				vCompanies::doneInsert();
			}
		}
		else
		{
			vCompanies::insert();
		}
	}
	public static function view()
	{
		if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		$nameCompany="";
		if(!empty($_GET['nameCompany']))
		{
			$nameCompany = @$_GET['nameCompany'];
		}
		elseif(!empty($_POST['nameCompany']))
		{
			$nameCompany = @$_POST['nameCompany'];
		}
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;
		if(@$_COOKIE['companyID'])
		{
			$companyID = @$_COOKIE['companyID'];
		}
		
		$ret = array();
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE nameCompany LIKE '%$nameCompany%' LIMIT {$from}, {$num_on_page}" );
		
	  while($row = mysqli_fetch_array($result))
	  {
		$ret[] = $row;
	  }
	  return $ret;
	  dateBase::close_bd();
	}
}

class products
{
	public static function edit()//редактирование продукта
	{
		if(isset($_POST['edit']))
		{
			$nameProduct = @$_POST['newnameProduct']; 
			$price = @$_POST['newPrice']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM products WHERE name = '$nameProduct'");
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			
			if(!preg_match("/^[a-z A-Z 0-9]+$/",@$_POST['newnameProduct']))
			{
				echo "<form id=text_new>Название может состоять только из букв английского алфавита и цифр</form>";
				products::checkEdit();
			}
			elseif(!preg_match("/^[0-9.]+$/",@$_POST['newPrice']))
			{
				echo "<form id=text_new>Цена может состоять только цифр<br></form>";
				products::checkEdit();
			}
			elseif(strlen(@$_POST['newnameProduct']) < 3 or strlen(@$_POST['newnameProduct']) > 30)
			{
				echo "<form id=text_new>Название должно быть не меньше 3-х символов и не больше 30</form>";
				products::checkEdit();
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Продукт с таким названием уже существует, придумайте другое</form>";
				products::checkEdit();
			}
			else
			{
				$id = $_GET['id'];
				mysqli_query(dateBase::connect(), "UPDATE products SET name = '$nameProduct', price = '$price' WHERE id = '$id'");
			    dateBase::close_bd();
			    vProducts::doneEdit();
			}
		}
		else
		{
			products::checkEdit();
		}
	}

	public static function checkEdit()
	{
		$id = $_GET['id'];
			$result = mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE id = '$id'" );
			
			$n = ""; 
			$p = "";
				while ($rslt = mysqli_fetch_row($result)) 
			{ 
				$n = $rslt[1]; 
				$p = $rslt[2]; 
			}
			vProducts::edit($n,$p);
	}

	public static function insert()
	{
		if(isset($_POST['insert'])) 
		{  
			$nameProduct = @$_POST['nameProduct']; 
			$price = @$_POST['price']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM products WHERE name = '$nameProduct'");
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			
			if(!preg_match("/^[a-z A-Z 0-9_^\.]+$/",@$_POST['nameProduct']))
			{
				echo "<form id=text_new>Название может состоять только из букв английского алфавита и цифр</form><br>";
				vProducts::insert();
			}
			elseif(!preg_match("/^[0-9]+$/",@$_POST['price']))
			{
				echo "<form id=text_new>Цена может состоять только цифр<br></form><br>";
				vProducts::insert();
			}
			elseif(strlen(@$_POST['nameProduct']) < 3 or strlen(@$_POST['nameProduct']) > 30)
			{
				echo "<form id=text_new>Название должно быть не меньше 3-х символов и не больше 30</form><br>";
				vProducts::insert();
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Продукт с таким названием уже существует, придумайте другое</form><br>";
				vProducts::insert();
			}
			else
			{
				$companyID = $_COOKIE['companyID'];
				$name = $_POST['nameProduct'];
				$price = $_POST['price'];
				mysqli_query(dateBase::connect(), "INSERT INTO products (name, price, companyID) VALUES ('$name', '$price', '$companyID')");
				dateBase::close_bd();
				vProducts::doneInsert();
			}
		}
		else
		{
			vProducts::insert();
		}
	}

	public static function view($all)
	{
		if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		 $nameProduct="";
		 $nameCompany="";
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;

		if(!empty($_GET['nameProduct']))
		{
			$nameProduct = @$_GET['nameProduct'];
		}
		elseif(!empty($_POST['nameProduct']))
		{
			$nameProduct = @$_POST['nameProduct'];
		}
		
		if(@$_GET["id"]=="")
		{
			$companyID=$_COOKIE['companyID'];
		}
		else
		{
			$companyID = @$_GET["id"];
		}
		$ret = array();
		if($all==1)
		{
			if(!empty($_GET['nameCompany']))
			{
				$nameCompany = @$_GET['nameCompany'];
			}
			elseif(!empty($_POST['nameCompany']))
			{
				$nameCompany = @$_POST['nameCompany'];
			}

			$result = mysqli_query(dateBase::connect(), "SELECT companies.nameCompany, products.name, products.price 
				FROM companies, products WHERE companies.id=products.companyID AND products.name LIKE '%$nameProduct%' AND companies.nameCompany LIKE '%$nameCompany%' 
				ORDER BY companies.nameCompany LIMIT {$from}, {$num_on_page}" );
		}
		else
		{
			$result = mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = $companyID AND name LIKE '%$nameProduct%' LIMIT {$from}, {$num_on_page}" );

		}
		while($row = mysqli_fetch_array($result))
		{
			$ret[] = $row;
		}
		return $ret;
		dateBase::close_bd();
	}

	public static function delete()
	{
		if(isset($_POST['delete']))
		{
			$id = $_GET['id'];
			$strSQL = "DELETE FROM products WHERE id=$id";
			mysqli_query(dateBase::connect(), $strSQL); 
			dateBase::close_bd();
			vProducts::doneDelete();
		}
		else
		{
			vProducts::delete();
		}
	}
}

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
			header("Location: index.php"); 
		}
	}
	public static function logout()
	{
		main::unset_cookie("userID", $userID);
		main::unset_cookie("log", $_POST["login"]);
		main::unset_cookie("pa", md5($_POST["passw"]));
		header("Location: ".$_SERVER['HTTP_REFERER']); 
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