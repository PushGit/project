<?php 

namespace controller;
use model\user as mUser;
use model\dateBase as dateBase;
use view\products as vProducts;
use view\companies as vCompanies;
use model\products as mProducts;
use model\companies as mCompanies;

class pages
{
	public static function controller_pages_products($all)
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
			if(@$_GET['nameProduct'])
			{
				$nameProduct = @$_GET['nameProduct'];
			}
			else
			{
				$nameProduct = @$_POST['nameProduct'];
			}
			if(@$_GET['nameCompany'])
			{
				$nameCompany = @$_GET['nameCompany'];
			}
			else
			{
				$nameCompany = @$_POST['nameCompany'];
			}
			if($all==1)
			{
				$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products, companies 
					WHERE companies.id=products.companyID AND products.name LIKE '%$nameProduct%' AND companies.nameCompany LIKE '%$nameCompany%'"));
			}
			else
			{
				$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = '$companyID' AND name LIKE '%$nameProduct%'"));
			}
			$num_on_page = 10;
			$pages = ceil($max_items/$num_on_page);
			for ($i=1; $i<=$pages; $i++)
			 {
				if($all==1)
				{
					if ($i!=$p) 
					{
					 	if($nameProduct == null && $nameCompany == null)
					 	{
					 		echo "<form id=text_new><a href=index.php?page=products&action=viewAll&p={$i}>{$i}</a>";
					 	}
					 	elseif($nameProduct == null)
					 	{
							echo "<form id=text_new><a href=index.php?page=products&action=viewAll&nameCompany=$nameCompany&p={$i}>{$i}</a>";
					 	}
					 	elseif($nameCompany == null)
					 	{
					 		echo "<form id=text_new><a href=index.php?page=products&action=viewAll&nameProduct=$nameProduct&p={$i}>{$i}</a>";
					 	}
					 	else
					 	{
					 		echo "<form id=text_new><a href=index.php?page=products&action=viewAll&nameProduct=$nameProduct&nameCompany=$nameCompany&p={$i}>{$i}</a>";
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

	public static function controller_pages($page)
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
		$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE nameCompany LIKE '%$nameCompany%'"));
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
}
?>