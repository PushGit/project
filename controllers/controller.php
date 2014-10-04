<?php 

namespace controller;
use view\first as vFirst;
use view\main as vMain;
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

class companies
{
	public static function view()
	{
		$data = mCompanies::view();
		vCompanies::view($data);
	}
	public static function edit()
	{
		mCompanies::edit();
	}
	public static function delete()
	{
		 mCompanies::delete();
	}

	public static function insert()
	{	
		mCompanies::insert();	
	}
}

class products
{
	public static function view()
	{
		$data = mProducts::view();
		$id = @$_GET["id"];
		if($id==$_COOKIE['companyID'])
		{
			vProducts::view($data);
		}
		else
		{
			vProducts::viewOther($data);
		}
	}
	public static function delete()
	{
		mProducts::delete();
	}
	public static function edit()
	{
		mProducts::edit();
	}
	public static function insert()
	{
		mProducts::insert();
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
			 		echo "<form id=text_new><a href=index.php?page=products&action=view&id={$companyID}&p={$i}>{$i}</a>";
			 	}
			 	else
			 	{
			 		echo "<form id=text_new><a href=index.php?page=products&action=view&id={$companyID}&nameProduct=$nameProduct&p={$i}>{$i}</a>";
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