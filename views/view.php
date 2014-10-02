<?php
// ------------ VIEW -------------------

/*Регистрация и логин*/
namespace view;
use model\dateBase as dateBase;
use model\products as products;
class first
{
	static function rek()
	{
		echo "<form method=post class=bar>";
		echo "здесь могла быть ваша реклама";
		echo "</form>";
	}
}
function view_login()
{
	echo "<form method=\"post\" action=index.php?action=login class=\"login\">";
    echo "<input type=\"text\" name=\"login\" placeholder='Login' id=search_box value=>";
    echo "<p>";
    echo "<input type=\"password\" name=\"password\" placeholder='Password' id=search_box value=>";
    echo "</p>";
    echo "<button type=\"submit\" id=button_new>Войти</button>";
    echo "</form> <br><br>";

    echo "<form method=\"post\" action=index.php?page=reg class=\"login\">";
    echo "<button type=\"submit\" id=button_new2>Зарегистрироваться</button>";
  	echo "</form>";
}



function view_hello($nameUser)
{
	
	echo "<form method=post action=index.php?page=logout class=\"hello\">";
	echo "Привет, $nameUser!";
	echo "<input type=submit id='button_new' value=Выход />";
	echo "</form>";
}

function view_reg()
{
	if(@$_COOKIE["query"]==1)
	{
		set_cookie("query","0");
		echo "<form id=text_new>Пользователь добавлен</form>
		<form method=post action=index.php> 
		<input class=button type=submit id=button_new value=ОК>";
	}
	else
	{
		echo "<form id=text_new>Добавить пользователя</form>
		<form method=post id=text_new> Логин <br>
		<input class=input required placeholder='Введите логин' id=search_box name=login value=>  
		<br><br> Пароль <br>
		<input required placeholder='Введите пароль' class=input id=search_box  name=passw value=> 
		<input type=hidden name=enter value=yes> 
		<br><br><button type=submit id=button_new>Зарегистрироваться</button>
		</form>";
	}
}
/*-------------------------------------------------------------*/


function view_companies($company_list)
{
	if (@$_POST['but'] && $_COOKIE["editCompany"]==2)
		{
			model\editCompany();
			echo "<form id=text_new><h2>Компания отредактирована!</h2></form>";
			
			if($_COOKIE["log"]!="")
			{
				echo "<form method=post action=index.php> 
				<input class=button type=submit id=button_new value=ОК>";
			}
			else
			{
				echo "<form method=post action=index.php?page=companies> 
				<input class=button type=submit id=button_new value=ОК>";
			}
			set_cookie("editCompany","0");
		}
	if(@$_COOKIE["editCompany"]==1)//редактирование компании
	{
		$id = $_GET['id'];
		
		$result = mysqli_query(dateBase::connect(), "SELECT * FROM companies WHERE id = '$id'" );
		
		while ($rslt = mysqli_fetch_row($result)) 
		{ 
			$n = $rslt[1]; 
			$a = $rslt[2]; 
			$p = $rslt[3]; 
		}
		dateBase::close_bd();


		echo "<form id=text_new><h2>Редактировать компанию '$n' </h2></form>
		<form method=post id=text_new>Наименование<br>

		<input class=input required name=newnameCompany id=search_box value=$n>  
		<br><br>Адрес<br>

		<input class=input required name=newadress id=search_box value=$a>  
		<br><br>Телефон<br>

		<input class=input required name=newphone id=search_box value=$p><br><br>

		<input class=button type=submit value=Редактировать id='button_new' name = but>  
		</form></h1>";
		set_cookie("editCompany","2");
		}
	if(@$_COOKIE["editCompany"]==0 || @!$_POST['but'] && $_COOKIE["editCompany"]==2)
	{
		if($company_list)
		{
			echo "<form id=text_new><h2>Компании </h2></form>";
			view_CompaniesSearch();
			echo "
			<form method=post id=text_new action=index.php?page=insertCompany> 
			
			<table class='tables'>
			<tr class='tab_footer'>
			<th class='tab_id'>id</th>
			<th>Наименование</th>
			<th class ='tab_adress'>Адрес</th>
			<th class='tab_phone'>Телефон</th>
			<th class='tab_items'>Просмотр товаров</th>
			</tr></form>";
			
			foreach ($company_list as $row)
			{
			  echo "<tr class='tab_content'>";
			  echo "<td class='tab_id'>" . $row['id'] . "</td>";
			  echo "<td>" . $row['name'] . "</td>";
			  echo "<td class='tab_adress'>" . $row['adress'] . "</td>";
			  echo "<td class='tab_phone'>" . $row['phone'] . "</td>";
			  echo "<td><a name=\"view\" href=\"index.php?page=companies&action=view&id=".$row["id"]."\"><img src=\"list.ico\" style=\"width: 16px; height: 16px;\">Товары</a></td>\n";
			  echo "</tr>";
			  }
			echo "</table>";
			\controller\controller_pages('companies');
		}
		else
		{
			echo "<form id=text_new><h2>Нет подходящей компании</h2> </form>
					<form method=post action=index.php?page=companies> 
					<br><input class=button type=submit id='button_new' value=Назад>
					</form>";
		}
	}
}

function view_CompaniesSearch()//форма не хочет работать черех get
{
			$p="";
			if(@$_POST['nameCompany'])
			{
				$p = $_POST['nameCompany'];
			}
			if(@$_GET['nameCompany'])
			{
				$p = $_GET['nameCompany'];
			}
	echo "<form method=post action=index.php?page=companies&action=search><input class=input name=nameCompany id=search_box value=$p><input class=button type=submit id='button_new' value='Поиск компании'/></form>";
			if(@$_POST['nameCompany'])
			{
				echo "<form method=post action=index.php?page=companies><input class=button type=submit id='button_new' value='Показать все'></form>";
			}
			if(@$_GET['nameCompany'])
			{
				echo "<form method=post action=index.php?page=companies><input class=button type=submit id='button_new' value='Показать все'></form>";
			}
}



function view_products($products_list)
{
		if (@$_POST['but'] && @$_COOKIE["editProduct"]==2)
		{
			products::editProduct();
			echo "<form id=text_new><h2>Продукт отредактирован! </h2></form>
			<form method=post action=index.php> 
			<input class=button type=submit id=button_new value=ОК>";
			set_cookie("editProduct","0");
		}
		if(@$_COOKIE["editProduct"]==1)//редактирование продукта
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
			
			echo "<form id=text_new><h2>Редактировать продукт '$n'</h2></form>
			<form method=post id=text_new> 
			Наименование
			<br><input class=input required name=newnameProduct id=search_box value=$n>  
			<br><br>Цена
			<br><input class=input required name=newPrice id=search_box value=$p>  
			<br><br><input class=button type=submit id='button_new' value=Редактировать name = but>  
			</form></h1>";
			set_cookie("editProduct","2");
		}
		if(@$_COOKIE["editProduct"]==0 || @!$_POST['but'] && @$_COOKIE["editProduct"]==2)/////////////////////////////
		{
			if($products_list)
			{
				/*echo "<br>
				<form method=post id=text_new action=index.php?page=insertProduct> <input class=button type=submit id='button_new' value=Добавить>
*/				echo "
				<form method=post id=text_new>
				<table class='tables'>
				<tr class='tab_footer'>
				<th class='tab_id'>id</th>
				<th>Товар</th>
				<th class ='tab_adress'>Стоимость</th>
				<th class='tab_phone'>Выбор действия</th>
				</tr></form>";

				foreach ($products_list as $row)
				  {
				  	 echo "<tr class='tab_content'>";
					
					  echo "<td>" . $row['id'] . "</td>";
					  echo "<td>" . $row['name'] . "</td>";
					  echo "<td>" . $row['price'] . "</td>";
					  echo "<td><a name=\"del\" href=\"index.php?page=products&action=delete&id=".$row["id"]."\"><img src=\"delete.png\" style=\"width: 16px; height: 16px;\"> Удалить</a>
					  <a name=\"edit\" href=\"index.php?page=products&action=edit&id=".$row["id"]."\"><img src=\"edit.png\" style=\"width: 16px; height: 16px;\">Редактировать</a>
					  </td>\n";
					  echo "</tr>";
				  }
				echo "</table>";
				\controller\controller_pages('products');
			}
			else
			{
				if(@$_GET['nameProduct'])
				{
					echo "<form id=text_new><h2>У нас нет подходящей продукции</h2> </form>
					<form method=post action=index.php> 
					<br><input class=button type=submit id='button_new' value=Назад>
					</form>";
				}
				else
				{
					echo "<form id=text_new><h2>У нас нет продукции</h2> </form>
					<form method=post action=index.php?page=insertProduct> 
					<br><input class=button type=submit id=button_new value=Добавить>
					</form>";
				}
			}
		}
	}


function view_my_products($products_list)
{
	$companyID = @$_GET['id'];
		$result = mysqli_query(dateBase::connect(), "SELECT name FROM companies WHERE id = '$companyID'" );
		
		while ($rslt = mysqli_fetch_row($result)) 
		{ 
			$n = $rslt[0]; 
		}
		dateBase::close_bd();
		if($products_list)
		{
			echo "<form method=post id=text_new><h2>Продукция компании '$n' </h2></form>";
			view_ProductsSearch();

			
			echo "<form method=post id=text_new>
			<table class='tables'>
			<tr class='tab_footer'>
			<th>Товар</th>
			<th class ='tab_adress'>Стоимость</th>
			</tr></form>";
				  	

			foreach ($products_list as $row)
			  {
				  echo "<tr class='tab_content'>";
				  echo "<td>" . $row['name'] . "</td>";
				  echo "<td>" . $row['price'] . "</td>";
				  echo "</tr>";
			  }
			echo "</table>";

			\controller\controller_pages_products($companyID);
			echo "<form method=post id=text_new  action=index.php?page=companies> 
			
			<br><input class=button type=submit id='button_new' value=Компании></form>";
	}
	else
	{
		if(@$_POST['nameProduct'])
				{
					echo "<form id=text_new><h2>У компании '$n' нет подходящей продукции</h2> </form>";

					$id=$_GET['id'];
					echo "<form method=post action=index.php?page=companies&action=view&id=$id><input class=button type=submit id='button_new' value='Показать всё'></form>
					<form method=post action=index.php?page=companies> 
					<br><input class=button type=submit id='button_new' value=Компании>
					</form>";

				}
				else
				{
					echo "<form id=text_new><h2>У компании '$n' нет продукции</h2> </form>
					<form method=post action=index.php?page=companies> 
					<br><input class=button type=submit id='button_new' value=Компании>
					</form>";
				}
	}
}

function view_ProductsSearch()
{
	$id=$_GET['id'];
	$p="";
	if(@$_POST['nameProduct'])
	{
		$p = $_POST['nameProduct'];
	}
	if(@$_GET['nameProduct'])
	{
		$p = $_GET['nameProduct'];
	}
	echo "<form method=post action=index.php?page=companies&action=search&id=$id><input class=input name=nameProduct id=search_box value=$p><input class=button type=submit id='button_new' value='Поиск продукции'/></form>";
	if(@$_POST['nameProduct'] || @$_GET['nameProduct'])
	{
		echo "<form method=post action=index.php?page=companies&action=view&id=$id><input class=button type=submit id='button_new' value='Показать все'></form>";
	}
}


function view_insertProduct()
{
	if($_COOKIE["insertProduct"]==0)
	{
		set_cookie("insertProduct","1");
		echo "<form id=text_new><h2>Продукт добавлен!</h2></form>";
		echo "<form method=post action=index.php> 
		<input class=button type=submit id='button_new' value=ОК>";
	}
	else
	{
		echo "<form id=text_new><h2>Добавить продукт</h2></form>
		<br><form method=post id=text_new action=index.php?page=insertProduct> 
		
		Наименование
		<br><input class=input required placeholder='Введите наименование' id=search_box name=nameProduct value=>  
		<br><br>Cтоимость
		<br><input class=input required placeholder='Введите стоимость' id=search_box name=price value=>  
		<input type=hidden name=enter value=yes> 
		<br><br><input class=button type=submit id='button_new' value=Добавить name = button>  
		</form></h1>
		<form method=post action=index.php> 
					<br><input class=button type=submit id='button_new' value=Назад>
					</form>";
	}
}

function view_insertCompany()
{
	if($_COOKIE["insertCompany"]==0)
	{
		set_cookie("insertCompany","1");
		echo "<form id=text_new><h2>Компания отредактирована!</h2></form>
		<form method=post action=index.php> 
		<input class=button type=submit id='button_new' value=ОК>";
	}
	else
	{
		echo "<form id=text_new><h2>Добавить компанию</h2></form>
		<form method=post id=text_new action=index.php?page=insertCompany> 
		Наименование
		<br><input class=input required placeholder='Введите наименование' id=search_box name=nameCompany value=>  
		<br><br>Адрес
		<br><input class=input required placeholder='Введите адрес' id=search_box name=adress value=>  
		<br><br>Телефон
		<br><input class=input required placeholder='Введите телефон' id=search_box name=phone value=>  
		<input type=hidden name=enter value=yes> 
		<br><br><input class=button type=submit value=Добавить id='button_new' name = button>  
		</form></h1>
		<form method=post action=index.php> 
					<br><input class=button type=submit id='button_new' value=Назад>
					</form>";
	}
}
?>
 