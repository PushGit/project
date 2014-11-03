<?php
namespace view;
use model\dateBase as dateBase;
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
	
	public static function dots()
	{

	}

	public static function viewPic()
	{
		echo "<div class='carousel slide' id='myCarousel'>
		  <ol class='carousel-indicators'>
		    <li id='0' class='active' data-target='#myCarousel' data-slide-to='0'></li>
		    <li id='1' data-target='#myCarousel' data-slide-to='1'></li>
		    <li id='2' data-target='#myCarousel' data-slide-to='2'></li>
		  </ol>
		  <div class='carousel-inner'>
		    <div class='item active'>
		      <img src='1.jpg'>
		      <div class='carousel-caption'>
		        <h4>Заголовок1</h4>
		        <p>Текст описания</p>
		      </div>
		    </div>
		    <div class='item'>
		      <img src='2.jpg'>
		      <div class='carousel-caption'>
		        <h4>Заголовок2</h4>
		        <p>Текст описания</p>
		      </div>
		    </div>
		    <div class='item'>
		      <img src='3.jpg'>
		      <div class='carousel-caption'>
		        <h4>Заголовок3</h4>
		        <p>Текст описания</p>
		      </div>
		    </div>
		</div>
		<script src='bootstrap.js'></script>
          <script src='jquery.js'></script> 
		<script>
			function prev()
			{
				console.log($(this));
				if($('#0').hasClass('active'))
				{
					$('#0').removeClass('active');
				 $('#2').addClass('active');
				}
				else if($('#1').hasClass('active'))
				{
					$('#1').removeClass('active');
				$('#0').addClass('active');
				}
				else if($('#2').hasClass('active'))
				{
					 $('#2').removeClass('active');
				 $('#1').addClass('active');
				}
			}
		
			function next()
			{
				console.log($(this));
				if($('#0').hasClass('active'))
				{
					$('#0').removeClass('active');
				 $('#1').addClass('active');
				}
				else if($('#1').hasClass('active'))
				{
					$('#1').removeClass('active');
				$('#2').addClass('active');
				}
				else if($('#2').hasClass('active'))
				{
					 $('#2').removeClass('active');
				 $('#0').addClass('active');
				}
			}
		</script>
		<a class='carousel-control left' onclick='prev()' data-slide='prev' href='#myCarousel'>&lsaquo;</a>
		<a class='carousel-control right' onclick='next()' data-slide='next' href='#myCarousel'>&rsaquo;</a>
		</div>";
		$id = @$_GET["id"];
		echo "<form method=post action=index.php?page=products&action=view&id=$id> 
				<input class=button type=submit id='button_new' value=Назад></form>";
	}

	public static function view($products_list, $all)
	{
		if($products_list)
		{
			echo "<form method=post id=text_new><h2>Продукция нашей компании</h2></form>";
			
			echo "<form method=post id=text_new action=index.php?page=products&action=insert> <input type=submit style='position:absolute; margin-left:290; top:110;' id='button_new' value='Добавить продукт'></form>";
			products::search($all);
			echo "
			<form method=post id=text_new>
			<table class='tables'>
			<tr class='tab_footer'>
			<th class='tab_id'>id</th>
			<th>Продукция</th>
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
			\controller\pages::controller_pages_products($all);
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

	public static function viewOther($products_list, $all)
	{
		$n ="";
		if(@$_GET['id']!=null)
		{
			$companyID = @$_GET['id'];
			$result = mysqli_query(dateBase::connect(), "SELECT nameCompany FROM companies WHERE id = '$companyID'" );
			while ($rslt = mysqli_fetch_row($result)) 
			{ 
				$n = $rslt[0]; 
			}
			dateBase::close_bd();
		}
		if($n!="")
		{
			if($products_list)
			{
				$id=$_GET['id'];
				echo "<form method=post action=index.php?page=products&action=viewPic&id=$id id=text_new><h2>Продукция компании '$n' 
				<input class=button type=submit id='button_new' value=Картинки></h2>
				</form>";
				\view\products::search($all);
			
				echo "<form method=post id=text_new>
				<table class='tables'>
				<tr class='tab_footer'>
				<th>Продукция</th>
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
				\controller\pages::controller_pages_products($all);
				echo "<form method=post id=text_new  action=index.php?page=companies&action=view> 
				<input class=button type=submit id='button_new' value=Компании></form>";
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
		else
		{
			if($products_list)
			{
				echo "<form method=post id=text_new><h2>Вся продукция</h2></form>";
				\view\products::search($all);
				
				echo "<form method=post id=text_new>
				<table class='tables'>
				<tr class='tab_footer'>
				<th>Компания</th>
				<th>Продукция</th>
				<th class ='tab_adress'>Стоимость</th>
				</tr></form>";				  	

				foreach ($products_list as $row)
				  {
					  echo "<tr class='tab_content'>";
					  echo "<td>" . $row['nameCompany'] . "</td>";
					  echo "<td>" . $row['name'] . "</td>";
					  echo "<td>" . $row['price'] . "</td>";
					  echo "</tr>";
				  }
				echo "</table>";
				\controller\pages::controller_pages_products($all);
				echo "<form method=post id=text_new  action=index.php?page=companies&action=view> 
				<input class=button type=submit id='button_new' value=Компании></form>";
			}
			else
			{
					echo "<form id=text_new><h2>Нет подходящей продукции</h2> </form>";
					echo "<form method=post action=index.php?page=products&action=viewAll><input class=button type=submit id='button_new' value='Показать всё'></form>
					<form method=post action=index.php?page=companies&action=view> 
					<br><input class=button type=submit id='button_new' value=Компании>
					</form>";
			}
		}
	}

	public static function search($all)
	{
		if($all==1)
		{
			$nameProduct="";
			$nameCompany="";
			if(@$_POST['nameProduct'])
			{
				$nameProduct = $_POST['nameProduct'];
			}
			if(@$_GET['nameProduct'])
			{
				$nameProduct = $_GET['nameProduct'];
			}
			if(@$_POST['nameCompany'])
			{
				$nameCompany = $_POST['nameCompany'];
			}
			if(@$_GET['nameCompany'])
			{
				$nameCompany = $_GET['nameCompany'];
			}
			echo "<input class=input placeholder='Компания' name=nameCompany id=nC value=$nameCompany>";
			echo "<input class=input placeholder='Продукт' name=nameProduct id=nP value=$nameProduct>
			
			<input class=button type=submit id='button_new'  onclick='compAjax()' value='Поиск'/><div id='tableCompany'>";
			echo "<script>
			var n = 0; 
			function compAjax()
			{ 
				var nameCompany = $('#nC').val();
				var nameProduct = $('#nP').val();
				$.ajax({
					type:'POST',
					url:'comp.php',
					data:{nameProduct:nameProduct,nameCompany:nameCompany},
					dataType:'html',
					success:function(data)
					{
						document.getElementById('tableCompany').innerHTML = data;
					}
				});
					  
				if($('#nC').val()!='' || $('#nP').val()!='')
				{
					n++;
					if(n>1)
					{
						document.getElementById('button_new1').remove(); 
					}
					var btn = document.createElement('input')
					btn.id = 'button_new1'
					btn.type = 'button'
					btn.value = 'Показать все'
					btn.class = 'show_allp'
					btn.setAttribute('onclick', 'click1();')
					document.body.appendChild(btn)
				}
			}
			function click1()
			{
				n=0;
				document.getElementById('button_new1').remove();  
				document.getElementById('nC').value = '';
				document.getElementById('nP').value = '';
				$.ajax({
							type:'POST',
							url:'comp.php',
							dataType:'html',
							success:function(data)
							{
								document.getElementById('tableCompany').innerHTML = data;
							}
						});
			}
			</script>";
		}
		else
		{
			if(@$_GET["id"]=="")
		{
			$id=$_COOKIE['companyID'];
		}
		else
		{
			$id = @$_GET["id"];
		}
		$p="";
		if(@$_POST['nameProduct'])
		{
			$p = $_POST['nameProduct'];
		}
		if(@$_GET['nameProduct'])
		{
			$p = $_GET['nameProduct'];
		}
			echo "<form method=post action=index.php?page=products&action=view&id=$id><input class=input placeholder='Продукт' name=nameProduct id=search_box value=$p><input class=button type=submit id='button_new' value='Поиск продукции'/></form>";
			if($p!="")
			{
				echo "<form method=post action=index.php?page=products&action=view&id=$id><input class=show_allp type=submit id='button_new' value='Показать все'></form>";
			}
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
		echo "<form action=index.php?page=products&action=insert id=text_new><h2>Добавить продукт</h2></form>
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
 