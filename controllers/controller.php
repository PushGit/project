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
		$all=0;
		$data = mProducts::view($all);
		$id = @$_GET["id"];
		if(@$_GET["id"]=="")
		{
			$id=$_COOKIE['companyID'];
		}
		if($id==$_COOKIE['companyID'])
		{
			vProducts::view($data,$all);
		}
		else
		{
			vProducts::viewOther($data,$all);
		}
	}
	public static function viewAll()
	{
		/*$all=1;
		$data = mProducts::view($all);
		vProducts::viewOther($data,$all);*/
		vProducts::viewAll();
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

function controller_pages_products($all)
	{
		echo "<div class=\"pages\">";
		if (empty($_GET['p']))
			{
			  $_GET['p'] = 1;
			}
		$p = $_GET['p'];
		if(@$_GET["id"]=="")
		{
			$companyID=$_COOKIE['companyID'];
		}
		else
		{
			$companyID = @$_GET["id"];
		}
		if(!empty($_GET['nameProduct']))
		{
			$nameProduct = @$_GET['nameProduct'];
		}
		else
		{
			$nameProduct = @$_POST['nameProduct'];
		}
		if($all==1)
		{
			$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products, companies WHERE companies.id=products.id AND products.name LIKE '%$nameProduct%'"));
		}
		else
		{
			$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = '$companyID' AND name LIKE '%$nameProduct%'"));
		}
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
			if($all==1)
			{
				if ($i!=$p) 
				{
				 	if($nameProduct == null)
				 	{
				 		echo "<form id=text_new><a href=index.php?page=products&action=viewAll&p={$i}>{$i}</a>";
				 	}
				 	else
				 	{
				 		echo "<form id=text_new><a href=index.php?page=products&action=viewAll&nameProduct=$nameProduct&p={$i}>{$i}</a>";
				 	}
			 	}
			 	else
			 	{
			 		echo "<form id=text_new><b>{$i}</b>";
			 	} 
			}
			else
			{
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
			 	else
			 	{
			 		echo "<form id=text_new><b>{$i}</b>";
			 	} 
			}
		 }
		echo "</div>";
		dateBase::close_bd();
	}

function controller_pages($page)
{
 	$id=@$_GET['id'];
	
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
	
	dateBase::close_bd();
}
?>