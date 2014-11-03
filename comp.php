<?php
namespace ajaxComp;
function connect()
	{
		$link  = mysqli_connect('localhost', 'root', '435123451', 'companies');
			if (!$link) {
			die('Ошибка соединения: ' . mysqli_error());
		}
		return $link;
	}
 function close_bd()
	{
		mysqli_close(connect());
	}	

	$companyID = @$_COOKIE['companyID'];
	$nameProduct = @$_POST['nameProduct'];
	$nameCompany = @$_POST['nameCompany'];
	
	//mysqli_query(connect(), "INSERT INTO products (name, companyID) VALUES ('$name', '$companyID')");
	$ret = array();
	if (empty($_GET["p"]))
		{
		  $p = 1;
		}
		else $p = $_GET["p"];
		 
		$num_on_page = 10;
		$from = ($p-1)*$num_on_page;
			$result = mysqli_query(connect(), "SELECT companies.nameCompany, products.name, products.price 
				FROM companies, products WHERE companies.id=products.companyID AND products.name LIKE '%$nameProduct%' AND companies.nameCompany LIKE '%$nameCompany%' 
				ORDER BY companies.nameCompany  LIMIT {$from}, {$num_on_page}");

		echo "<form method=post id=text_new>
				<table class='tables'>
				<tr class='tab_footer'>
				<th>Компания</th>
				<th>Продукция</th>
				<th class ='tab_adress'>Стоимость</th>
				</tr></form>";				  	
		while($row = mysqli_fetch_array($result))
		{
		  $ret[] = $row;
		  echo "<tr class='tab_content'>";
		  echo "<td>" . $row['nameCompany'] . "</td>";
		  echo "<td>" . $row['name'] . "</td>";
		  echo "<td>" . $row['price'] . "</td>";
		  echo "</tr>";
		}
echo "</table>"; 

controller_pages_products($nameProduct, $nameCompany);
				echo "<form method=post id=text_new  action=index.php?page=companies&action=view> 
				<input class=button type=submit id='button_new' value=Компании></form>";
		return $ret;
	close_bd();

function controller_pages_products($nameProduct, $nameCompany)
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
			if(@$_POST['nameProduct'])
			{
				$nameProduct = @$_POST['nameProduct'];
			}
			if(@$_GET['nameCompany'])
			{
				$nameCompany = @$_GET['nameCompany'];
			}
			if(@$_POST['nameCompany'])
			{
				$nameCompany = @$_POST['nameCompany'];
			}
			$max_items = mysqli_num_rows(mysqli_query(connect(), "SELECT * FROM products, companies 
				WHERE companies.id=products.companyID AND products.name LIKE '%$nameProduct%' AND companies.nameCompany LIKE '%$nameCompany%'"));
			
			
			$num_on_page = 10;
			$pages = ceil($max_items/$num_on_page);
			for ($i=1; $i<=$pages; $i++)
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
			echo "</div>";
			close_bd();
		}



?>