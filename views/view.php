<?php
// ------------ VIEW -------------------

/*Регистрация и логин*/
namespace view;
use model\dateBase as dateBase;
class first
{
	static function rek()
	{
		echo "<form method=post class=bar>";
		echo "здесь могла быть ваша реклама";
		echo "</form>";
	}
}
class main
{
	

	public static function login()
	{
		echo "<form method=post action=index.php?page=main&action=login class=login>";
	    echo "<input type=text required name=login placeholder='Login' id=search_box value=>";
	    echo "<p>";
	    echo "<input type=password required name=password placeholder='Password' id=search_box value=>";
	    echo "</p>";
	    echo "<button type=submit id=button_new>Войти</button>";
	    echo "</form> <br><br>";

	    echo "<form method=post action=index.php?page=main&action=reg class=login>";
	    echo "<button type=submit id=button_new class = registration>Зарегистрироваться</button>";
	  	echo "</form>";
	}

	public static function hello($nameUser)
	{
		
		echo "<form method=post action=index.php?page=main&action=logout class=hello>";
		echo "Привет, $nameUser!";
		echo "<input type=submit id='button_new' value=Выход />";
		echo "</form>";
	}
	
	public static function doneReg()
	{
		echo "<form id=text_new>Пользователь добавлен</form>
			<form method=post action=index.php> 
			<input class=button type=submit id=button_new value=ОК>";
	}

	public static function registration()
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

class companies
{
	public static function doneEdit()//отредактирована
	{
		echo "<form id=text_new><h2>Компания отредактирована!</h2></form>";
		echo "<form method=post action=index.php> 
		<input class=button type=submit id=button_new value=ОК>";
	}

	public static function edit()//редактирование компании
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

		echo "<form method=post id=text_new><h2>Редактировать компанию '$n' </h2>
		Наименование<br>

		<input class=input required name=newnameCompany id=search_box value=$n>  
		<br><br>Адрес<br>

		<input class=input required name=newadress id=search_box value=$a>  
		<br><br>Телефон<br>

		<input class=input required name=newphone id=search_box value=$p><br><br>

		<input class=button type=submit value=Редактировать id='button_new' name = edit>  
		</form></h1>";
		echo "<form method=post action=index.php> 
		<br><input class=button type=submit id='button_new' value=Назад>
		</form>";
	}

	public static function myCompany()
	{
		$id = @$_COOKIE['companyID'];
			
			echo "<form action=index.php?page=companies&action=edit&id=$id method=post> 
			<br><input class=button type=submit id='button_new' value='Редактировать компанию' name = but/></form>";
			echo "<br><form method=post action=index.php?page=companies&action=delete&id=$id><input class=button type=submit id='button_new' value='Удалить компанию' name = but/></form>";
			
			if(\model\main::have()!="") 
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

	public static function view($company_list)
	{
		if($company_list)
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
			echo "<form id=text_new><h2>Компании </h2></form>";
			echo "<form method=post action=index.php?page=companies&action=view><input class=input name=nameCompany id=search_box value=$p><input class=button type=submit id='button_new' value='Поиск компании'/></form>";
			
			if(@$_POST['nameCompany'] || @$_GET['nameCompany'])
			{
				echo "<form method=post action=index.php?page=companies&action=view><input class=show_all type=submit id='button_new' value='Показать все'></form>";
			}
			
			echo "<form method=post id=text_new action=index.php?page=insertCompany> 
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
			  echo "<td><a name=\"view\" href=\"index.php?page=products&action=view&id=".$row["id"]."\"><img src=\"list.ico\" style=\"width: 16px; height: 16px;\">Товары</a></td>\n";
			  echo "</tr>";
			  }
				echo "</table>";
				\controller\controller_pages('companies');
		}
		else
		{
			echo "<form id=text_new><h2>Нет подходящей компании</h2> </form>
			<form method=post action=index.php?page=companies&action=view> 
			<br><input class=button type=submit id='button_new' value=Назад>
			</form>";
		}
	}

	public static function doneInsert()
	{
		echo "<form id=text_new><h2>Компания добавлена! </h2></form>
		<form method=post action=index.php> 
		<input class=button type=submit id=button_new value=ОК>";
	}

	public static function insert()
	{
		echo "<form id=text_new><h2>Добавить компанию</h2></form>
		<form method=post action=index.php?page=companies&action=insert id=text_new> 
		Наименование
		<br><input class=input required placeholder='Введите наименование' id=search_box name=nameCompany value=>  
		<br><br>Адрес
		<br><input class=input required placeholder='Введите адрес' id=search_box name=adress value=>  
		<br><br>Телефон
		<br><input class=input required placeholder='Введите телефон' id=search_box name=phone value=>  
		<input type=hidden name=enter value=yes> 
		<br><br><input class=button type=submit value=Добавить id='button_new' name = insert>  
		</form>";
	}

	public static function doneDelete()
	{
		echo "<form id=text_new><h2>Компания удалена!</h2></form>
		<form method=post action=index.php> 
		<input class=button type=submit id='button_new' value=ОК>";
	}

	public static function delete()
	{
		echo "<form id=text_new><h2>Вы уверены что хотите удалить компанию?</h2></form>
		<form method=post id=text_new>
		<br><input class=button type=submit value=Да id='button_new' name = delete>  
		</form>
		<form method=post id=text_new action=index.php>
		<br><input class=button type=submit value=Нет id='button_new' name = button>  
		</form>";
	}
}
class products
{
	public static function doneEdit()
	{
		$id = @$_COOKIE['companyID'];
		echo "<form id=text_new><h2>Продукт отредактирован! </h2></form>
		<form method=post action=index.php?page=products&action=view&id=$id> 
		<input class=button type=submit id=button_new value=ОК>";
	}

	public static function edit($n,$p)
	{
		$idCompany = $_COOKIE['companyID'];
		echo "<form id=text_new><h2>Редактировать продукт '$n'</h2></form>
		<form method=post id=text_new> 
		Наименование
		<br><input class=input required name=newnameProduct id=search_box value='$n'>  
		<br><br>Цена
		<br><input class=input required name=newPrice id=search_box value='$p'>  
		<br><br><input class=button type=submit id='button_new' value=Редактировать name = edit>  
		</form></h1>
		<form method=post action=index.php?page=products&action=view&id=$idCompany> 
		<br><input class=button type=submit id='button_new' value=Назад>
		</form>";
	}

	public static function view($products_list)
	{
		if($products_list)
		{
			echo "<form method=post id=text_new><h2>Продукция нашей компании</h2></form>";
			products::search();
			echo "
			<form method=post id=text_new action=index.php?page=products&action=insert> <input class=show_all type=submit id='button_new' value='Добавить продукт''>
			
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
			\controller\controller_pages_products();
		}
		else
		{
			if(@$_GET['nameProduct'] || @$_POST['nameProduct'] )
			{
				$id = $_GET['id'];
				echo "<form id=text_new><h2>У нас нет подходящей продукции</h2> </form>
				<form method=post action=index.php?page=products&action=view&id=$id> 
				<br><input class=button type=submit id='button_new' value=Назад>
				</form>";
			}
			else
			{
				echo "<form id=text_new><h2>У нас нет продукции</h2> </form>
				<form method=post action=index.php> 
				<br><input class=button type=submit id=button_new value=ОК>
				</form>";
			}
		}
	}

	public static function viewOther($products_list)
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
			\view\products::search();
		
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
			echo "<form method=post id=text_new  action=index.php?page=companies&action=view> 
			<br><input class=button type=submit id='button_new' value=Компании></form>";
		}
		else
		{
			if(@$_POST['nameProduct'])
			{
				$id=$_GET['id'];
				echo "<form id=text_new><h2>У компании '$n' нет подходящей продукции</h2> </form>";
				echo "<form method=post action=index.php?page=products&action=view&id=$id><input class=button type=submit id='button_new' value='Показать всё'></form>
				<form method=post action=index.php?page=companies&action=view> 
				<br><input class=button type=submit id='button_new' value=Компании>
				</form>";
			}
			else
			{
				echo "<form id=text_new><h2>У компании '$n' нет продукции</h2> </form>
				<form method=post action=index.php?page=companies&action=view> 
				<br><input class=button type=submit id='button_new' value=Компании>
				</form>";
			}
		}
	}

	public static function search()
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
		echo "<form method=post action=index.php?page=products&action=view&id=$id><input class=input name=nameProduct id=search_box value=$p><input class=button type=submit id='button_new' value='Поиск продукции'/></form>";
		if($p!="")
		{
			echo "<form method=post action=index.php?page=products&action=view&id=$id><input class=show_allp type=submit id='button_new' value='Показать все'></form>";
		}
	}
	public static function doneDelete()
	{
		$id=$_COOKIE['companyID'];
		if(\model\main::have()!="")
		{
			echo "<form id=text_new><h2>Продукт удален!</h2></form>
			<form method=post action=index.php?page=products&action=view&id=$id> 
			<input class=button type=submit id='button_new' value=ОК>";
		}
		else
		{
			echo "<form id=text_new><h2>Последний продукт удален!</h2></form>
			<form method=post action=index.php> 
			<br><input class=button type=submit id='button_new' value=ОК>
			</form>";
		}
		
	}

	public static function delete()
	{
		$idCompany=$_COOKIE['companyID'];
		$id=$_GET['id'];
		echo "<form id=text_new><h2>Вы уверены что хотите удалить продукт?</h2></form>
		<form method=post id=text_new >
		<br><input class=button type=submit value=Да id='button_new' name = delete>  
		</form>
		<form method=post id=text_new action=index.php?page=products&action=view&id=$idCompany>
		<br><input class=button type=submit value=Нет id='button_new'>  
		</form>";
	}


	public static function doneInsert()
	{
		$id=$_COOKIE['companyID'];
		echo "<form id=text_new><h2>Продукт добавлен!</h2></form>
		<form method=post action=index.php?page=products&action=view&id=$id> 
		<input class=button type=submit id='button_new' value=ОК>";
	}

	public static function insert()
	{
		$id=$_COOKIE['companyID'];
		echo "<form id=text_new><h2>Добавить продукт</h2></form>
		<br><form method=post id=text_new> 
		Наименование
		<br><input class=input required placeholder='Введите наименование' id=search_box name=nameProduct value=>  
		<br><br>Cтоимость
		<br><input class=input required placeholder='Введите стоимость' id=search_box name=price value=>  
		<input type=hidden name=enter value=yes> 
		<br><br><input class=button type=submit id='button_new' value=Добавить name = insert>  
		</form></h1>";
		if(\model\main::have()!="")
		{
			echo "<form method=post action=index.php?page=products&action=view&id=$id> 
			<br><input class=button type=submit id='button_new' value=Назад>
			</form>";
		}
		else
		{
			echo "<form method=post action=index.php> 
			<br><input class=button type=submit id='button_new' value=Назад>
			</form>";
		}
	}
}
?>
 