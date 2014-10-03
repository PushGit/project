<?php

/*////////////////// Подключение к базе ////////////////////////////*/
namespace model;
use view as view;
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
	public static function getCompanies($params = array())
	{
		if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		 
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;
		
		$ret = array();
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM companies LIMIT {$from}, {$num_on_page}" );
		
	  while($row = mysqli_fetch_array($result))
	  {
		$ret[] = $row;
	  }
	  return $ret;
	  dateBase::close_bd();
	}
	
	public static function delete($id)
	{
		mysqli_query(dateBase::connect(), "DELETE FROM companies WHERE id=$id") or die(mysqli_error(dateBase::connect())); 
		dateBase::close_bd();
		\controller\main::unset_cookie("companyID","0");
		header("Location:index.php?namespace=view&page=companies&action=doneDelete");
	}
	public static function edit()//редактирование компании
	{
		$id = $_GET['id'];
		$newadress = $_POST['newadress'];
		$newphone = $_POST['newphone'];
		$newnameCompany = $_POST['newnameCompany'];
		mysqli_query(dateBase::connect(), "UPDATE companies SET name = '$newnameCompany', adress = '$newadress', phone = '$newphone' WHERE id = '$id'");
	    dateBase::close_bd();
	}

	public static function insert()//добавление компании
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
	   
	    $result = mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE name = '$name'");
			while ($rslt = mysqli_fetch_row($result)) 
			{ 
				$newID = $rslt[0]; 
			}
			\controller\main::set_cookie("companyID","$newID");
			dateBase::close_bd();
		header("Location:index.php?namespace=view&page=companies&action=doneInsert");
	}
	public static function getCompaniesSearch($nameCompany)
	{
		if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		 
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;
		$companyID = $_COOKIE['companyID'];
		$ret = array();
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE name LIKE '%$nameCompany%' LIMIT {$from}, {$num_on_page}" );
		
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
	public static function getProducts()
	{
		if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		 
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;

		$companyID = @$_GET['id'];
		if($companyID==null)
		{
			$companyID=$_COOKIE['companyID'];
		}
		
		$ret = array();
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = $companyID LIMIT {$from}, {$num_on_page}" );
		
	  while($row = mysqli_fetch_array($result))
	  {
		$ret[] = $row;
	  }
	  return $ret;
	  dateBase::close_bd();
	}

	public static function edit()//редактирование продукта
	{
		$id = $_GET['id'];
		$newnameProduct = $_POST['newnameProduct'];
		$newPrice = $_POST['newPrice'];
		mysqli_query(dateBase::connect(), "UPDATE products SET name = '$newnameProduct', price = '$newPrice' WHERE id = '$id'");
	    dateBase::close_bd();
	}

	public static function insert()//добавление продукта
	{
			//добавляем продукт и записываем ид компании
			$companyID = $_COOKIE['companyID'];
			$name = $_POST['nameProduct'];
			$price = $_POST['price'];
			mysqli_query(dateBase::connect(), "INSERT INTO products (name, price, companyID) VALUES ('$name', '$price', '$companyID')");
			dateBase::close_bd();

	}

	public static function search($nameProduct)
	{
		if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		 
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;

		if(!empty($_GET['nameProduct']))
		{
			$nameProduct = @$_GET['nameProduct'];
		}
		if(!empty($_POST['nameProduct']))
		{
			$nameProduct = @$_POST['nameProduct'];
		}
		/*else
		{*/
			$companyID = @$_GET["id"];
		//}
		$ret = array();
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = $companyID AND name LIKE '%$nameProduct%' LIMIT {$from}, {$num_on_page}" );
		
		while($row = mysqli_fetch_array($result))
		{
			$ret[] = $row;
		}
		return $ret;
		dateBase::close_bd();
	}

	public static function delete()
	{
		$id = $_GET['id'];
		$strSQL = "DELETE FROM products WHERE id=$id";
		mysqli_query(dateBase::connect(), $strSQL); 
		dateBase::close_bd();
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
		header("Location:index.php?namespace=view&page=main&action=doneReg");
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
			$id = @$_COOKIE['companyID'];
			echo "<form id=text_new><h2>Наша компания: $nameCompany </h2></form>";
			echo "<form action=index.php?page=companies&action=edit&id=$id method=post> 
			<br><input class=button type=submit id='button_new' value='Редактировать компанию' name = but/></form>";
			echo "<br><form method=post action=index.php?namespace=view&page=companies&action=delete&id=$id><input class=button type=submit id='button_new' value='Удалить компанию' name = but/></form>";
			
			if(have()!="") 
			{
				$id = @$_COOKIE['companyID'];
				echo "<br><form method=post id=text_new action=index.php?page=products&action=view&id=$id> <input class=button type=submit id='button_new' value='Продукция компании'></form>";
			}
			else
			{
				echo "<br><form id=text_new><h2>У нашей компании нет продукции</h2></form>";
				echo "<form method=post id=text_new action=index.php?page=products&action=insert> <input class=button type=submit id='button_new' value='Добавить продукцию'></form>";
			}
		}
	}
}

function have()
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

	function login()
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
			setcookie("companyID", $companyID, time() + 3600*24*30*12, "/");
			setcookie("userID", $userID, time() + 3600*24*30*12, "/");
			setcookie("log", $_POST["login"], time() + 3600*24*30*12, "/");
			setcookie("pa", md5($_POST["passw"]), time() + 3600*24*30*12, "/");
			header("Location: index.php"); 
		}
	}

?>