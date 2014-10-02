<?php 

namespace controller;
use view\first as vFirst;
use model\login as login;
use model\user as user;
use model\products as products;
use model\dateBase as dateBase;
use model\companies as mCompanies;
/*------     куки    ---------  */

function set_cookie($var, $n){
	setcookie("$var", $n, time() + 3600*24*30*12, "/");
}

function controller_login()
{
	@$nameUser = $_COOKIE['log'];

	if(@$_COOKIE['log']=="")
    {
      view\view_login();
    }
    else
    {
      view\view_hello($nameUser);
      vFirst::rek();
    }
}

function logout()
{
	setcookie("companyID", $companyID, time() - 3600*24*30*12, "/");
	setcookie("userID", $userID, time() - 3600*24*30*12, "/");
	setcookie("log", $_POST["login"], time() - 3600*24*30*12, "/");
	setcookie("pa", md5($_POST["passw"]), time() - 3600*24*30*12, "/");
	header("Location: ".$_SERVER['HTTP_REFERER']); 
}
class companies
{
	public static function controller_companies()
	{
	$id = @$_GET["id"];

	if (@$_POST["action"]=="search" || @$_GET["action"]=="search")
	{
		if(@$_POST["id"] || @$_GET["id"])
		{
			if(@$_POST['nameProduct'])
			{
				$nameProduct = @$_POST['nameProduct'];
			}
			else
			{
				$nameProduct = @$_GET['nameProduct'];
			}
		
			$data = products::getProductsSearch($nameProduct);
			view\view_my_products($data);
		}
		else
		{
			if(@$_POST['nameCompany'])
			{
				$nameCompany = @$_POST['nameCompany'];
			}
			else
			{
				$nameCompany = @$_GET['nameCompany'];
			}
				
			$data = companies::getCompaniesSearch($nameCompany);
			view\view_companies($data);
			}
		}
	elseif (@$_GET["action"]=="view")
	{
		$data = products::getMyProducts();
		view\view_my_products($data);
	}
	else
	{
		switch(@$_GET["action"])
		{
			case "delete": companies::delete_companies($id);
			break;
			
			case "edit": companies::edit_companies($id);
			break;
		}
		$data =companies::getCompanies();
		view\view_companies($data);
	}
	public static function controller_insertCompany()
	{
		view\view_insertCompany();
		if(!empty($_POST['nameCompany'])) 
		{  
		  //ïðîâåðêà íåò ëè óæå òàêîé êîìïàíèè
			$nameCompany = $_POST['nameCompany']; 
			$res = mysqli_query(dateBase::connect(), "SELECT id FROM companies WHERE name = '$nameCompany'");
			$row = mysqli_fetch_row($res);
			$count = $row[0];
			dateBase::close_bd();
			if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['nameCompany']))
			{
				echo "<form id=text_new>Íàçâàíèå ìîæåò ñîñòîÿòü òîëüêî èç áóêâ àíãëèéñêîãî àëôàâèòà è öèôð";
			}
			elseif(strlen($_POST['nameCompany']) < 3 or strlen($_POST['nameCompany']) > 30)
			{
				echo "<form id=text_new>Íàçâàíèå äîëæíî áûòü íå ìåíüøå 3-õ ñèìâîëîâ è íå áîëüøå 30";
			}
			elseif (!empty($count))
			{
				echo "<form id=text_new>Êîìïàíèÿ ñ òàêèì íàçâàíèåì óæå ñóùåñòâóåò, ïðèäóìàéòå äðóãîå";
			}
			else
			{
				companies::addCompany();
			}
		}
	}

}

public static function controller_free_companies()
{
	$data = companies::getCompanies(); 
	view\view_companies($data);
}
}
class products
{

public static function controller_products()
{
	$id = @$_GET["id"];

	if(@$_GET["nameProduct"])
	{
		$nameProduct=$_GET["nameProduct"];
		$data = products::getProductsSearch($nameProduct);
		view\view_products($data);
	}
	else
	{
		switch(@$_GET["action"])
		{
			case "delete": 
			$strSQL = "DELETE FROM products WHERE id=$id";
			mysqli_query(dateBase::connect(), $strSQL); 
			header("Location:index.php");
			dateBase::close_bd();
			break;
			
			case "edit":
			setcookie("editProduct", 1, time() + 3600*24*30*12, "/");
			header("Location:index.php?page=products&id=$id");
			break;
			
			case "insert":
			setcookie("insertProduct", 1, time() + 3600*24*30*12, "/");
			break;
		}
		$data = products::getProducts();
		
		if (@$_COOKIE["otherCompanyID"]==0)
		{
			\view\view_products($data);
		}
		else
		{
			view\view_my_products($data);
		}
	}
}
public static function controller_insertProduct()
{
	view\view_insertProduct();
	if(!empty($_POST['nameProduct'])) 
	{  
		$nameProduct = $_POST['nameProduct']; 
		$price = $_POST['price']; 
		$res = mysqli_query(dateBase::connect(), "SELECT id FROM products WHERE name = '$nameProduct'");
		$row = mysqli_fetch_row($res);
		$count = $row[0];
		dateBase::close_bd();
		
		if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['nameProduct']))
		{
			echo "<form id=text_new>Íàçâàíèå ìîæåò ñîñòîÿòü òîëüêî èç áóêâ àíãëèéñêîãî àëôàâèòà è öèôð";
		}
		elseif(!preg_match("/^[0-9]+$/",$_POST['price']))
		{
			echo "<form id=text_new>Öåíà ìîæåò ñîñòîÿòü òîëüêî öèôð<br>";
		}
		elseif(strlen($_POST['nameProduct']) < 3 or strlen($_POST['nameProduct']) > 30)
		{
			echo "<form id=text_new>Íàçâàíèå äîëæíî áûòü íå ìåíüøå 3-õ ñèìâîëîâ è íå áîëüøå 30";
		}
		elseif (!empty($count))
		{
			echo "<form id=text_new>Ïðîäóêò ñ òàêèì íàçâàíèåì óæå ñóùåñòâóåò, ïðèäóìàéòå äðóãîå";
		}
		else
		{
			products::addProduct();
		}
	}
}
 function controller_reg()//ðåãèñòðàöèÿ
{
	view\view_reg();
	if(!empty($_POST['login']) and !empty($_POST['passw'])) 
	{   
		$name = $_POST['login']; 
		$res = mysqli_query(dateBase::connect(), "SELECT id FROM users WHERE name = '$name'");
		$row = mysqli_fetch_row($res);
		$count = $row[0];
		dateBase::close_bd();
		if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
		{
			echo "<form id=text_new>Ëîãèí ìîæåò ñîñòîÿòü òîëüêî èç áóêâ àíãëèéñêîãî àëôàâèòà è öèôð";
		}
		elseif(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
		{
			echo "<form id=text_new>Ëîãèí äîëæåí áûòü íå ìåíüøå 3-õ ñèìâîëîâ è íå áîëüøå 30";
		}
		//ïðîâåðêà íåò ëè óæå òàêîãî ïîëüçîâàòåëÿ
		elseif (!empty($count))
		{
			echo "<form id=text_new>Ïîëüçîâàòåëü ñ òàêèì ëîãèíîì óæå ñóùåñòâóåò â áàçå äàííûõ";
		}
		else
		{
			user::addUser();
		}
	}
}

// 
//======================================
function login()
{
	if ((empty($_COOKIE['log'])) && (empty($_COOKIE['pa'])))
	{ 
		view\view_login();
	}
	else 
	{
		\model\getCookies();
	}
}	
//-----------------------------

function controller_pages_products()
{
	echo "<div class=\"pages\">";
	if (empty($_GET['p']))
		{
		  $_GET['p'] = 1;
		}
	$p = $_GET['p'];

	
	if(@$_POST['nameProduct'])
	{
		$nameProduct = @$_POST['nameProduct'];
	}
	else
	{
		$nameProduct = @$_GET['nameProduct'];
	}
	
	$companyID = $_GET['id'];
	$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = '$companyID' AND name LIKE '%$nameProduct%'"));
	$num_on_page = 10;
	$pages = ceil($max_items/$num_on_page);
	for ($i=1; $i<=$pages; $i++)
	 {
	 	if(@$_POST['nameProduct'])
	{
		$nameProduct = @$_POST['nameProduct'];
	}
	else
	{
		$nameProduct = @$_GET['nameProduct'];
	}
		 if ($i!=$p) echo "<a href=\"index.php?page=companies&action=view&id={$companyID}&nameProduct=$nameProduct&p={$i}\">{$i}</a>";
		 else echo "<b>{$i}</b>";
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
	if ($page == "products")
	{
		$companyID = $_COOKIE['companyID'];
		$nameProduct = @$_GET['nameProduct'];
		$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM products WHERE companyID = '$companyID' AND name LIKE '%$nameProduct%'"));
	}
	else
	{
		if(@$_POST['nameCompany'])
		{
			$nameCompany = @$_POST['nameCompany'];
		}
		else
		{
			$nameCompany = @$_GET['nameCompany'];
		}

		$max_items = mysqli_num_rows(mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE name LIKE '%$nameCompany%'"));
	}
	 $num_on_page = 10;
	 $pages = ceil($max_items/$num_on_page);
	 for ($i=1; $i<=$pages; $i++)
	 {
	 		if($page=='companies')//ëèñòàåì êîìïàíèè
		 	{
			 	if ($i!=$p) 
			 	{
			 		if(@$_POST['nameCompany'])
			 		{
			 			$nameCompany = @$_POST['nameCompany'];
			 		}
			 		else
			 		{
			 			$nameCompany = @$_GET['nameCompany'];
			 		}

			 		echo "<form id=text_new><a href=\"index.php?page=companies&p={$i}&nameCompany=$nameCompany\">{$i}</a>";
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
			 		$nameProduct = @$_GET['nameProduct'];
			 		if(@$_GET['nameProduct'])
			 		{
			 			echo "<form id=text_new><a href=\"index.php?p={$i}&nameProduct=$nameProduct\">{$i}</a>";
				 	}
				 	else
				 	{
				 		echo "<form id=text_new><a href=\"index.php?p={$i}\">{$i}</a>";
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

function main_controller()
{
	if(@$_GET['action']=='search') 
	{
		$data = products::getProductsSearch($nameProduct);
		view\view_products($data);
	}
	if(@$_GET['action']=='login')
	{
		login::login();
	}
	else
	{
		if ((empty($_COOKIE['log'])) && (empty($_COOKIE['pa'])))
		{ 
			set_cookie('insertCompany','1');
			echo "<form id=text_new><a href=\"index.php?page=reg\" >Çàðåãèñòðèðóéòåñü</a> <p>";
			echo "èëè<p>";
			echo "<a href=\"index.php?page=login\">Âîéäèòå</a></form>";
		}
		else 
		{
			$nameUser = $_COOKIE['log'];
			set_cookie("otherCompanyID","0");
			
			user::checkUser();
			//checkUser();
		}
	}
}



}



?>