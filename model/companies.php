<?php
namespace model;
use view as view;
use view\main as vMain;
use view\companies as vCompanies;
use view\products as vProducts;

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
?>