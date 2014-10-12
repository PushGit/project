<?php
namespace model;
use view as view;
use view\main as vMain;
use view\companies as vCompanies;
use view\products as vProducts;

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
?>