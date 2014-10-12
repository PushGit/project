<?php
namespace view;
use model\dateBase as dateBase;
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

		echo "<form method=post id=text_new><header><h2>Редактировать компанию '$n' </header></h2>
		Наименование
		<input class=input required name=newnameCompany id=search_box value=$n> 
		Адрес
		<input class=input required name=newadress id=search_box value=$a>
		Телефон
		<input class=input required name=newphone id=search_box value=$p>
		<input class=button type=submit value=Редактировать id='button_new' name = edit>  
		</form></h1>
		<form method=post action=index.php> 
		<input class=button type=submit id='button_new' value=Назад>
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
			echo "<p><form method=post action=index.php?page=companies&action=view><input class=input name=nameCompany id=search_box value=$p><input class=button type=submit id='button_new' value='Поиск компании'/></form>";
			
			if(@$_POST['nameCompany'] || @$_GET['nameCompany'])
			{
				echo "<form method=post action=index.php?page=companies&action=view><input type=submit id='button_new' value='Показать все'></form>";
			}
			
			echo "<form method=post id=text_new action=index.php?page=insertCompany> 
			<table class='tables'>
			<tr class='tab_footer'>
			<th class='tab_id'>id</th>
			<th>Наименование</th>
			<th class ='tab_adress'>Адрес</th>
			<th class='tab_phone'>Телефон</th>
			<th class='tab_items'>Просмотр продукции</th>
			</tr></form>";
			
			foreach ($company_list as $row)
			{
			  echo "<tr class='tab_content'>";
			  echo "<td class='tab_id'>" . $row['id'] . "</td>";
			  echo "<td>" . $row['nameCompany'] . "</td>";
			  echo "<td class='tab_adress'>" . $row['adress'] . "</td>";
			  echo "<td class='tab_phone'>" . $row['phone'] . "</td>";
			  echo "<td><a name=\"view\" href=\"index.php?page=products&action=view&id=".$row["id"]."\"><img src=\"list.ico\" style=\"width: 16px; height: 16px;\">Продукция</a></td>\n";
			  echo "</tr>";
			  }
				echo "</table>";
				\controller\pages::controller_pages('companies');
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
?>
 