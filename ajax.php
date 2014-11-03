<?php
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

	//$companyID = $_COOKIE['companyID'];
	//$nameProduct = $_POST['nameProduct'];
	
	//mysqli_query(connect(), "INSERT INTO products (name, companyID) VALUES ('$name', '$companyID')");
	$ret = array();
			$result = mysqli_query(connect(), "SELECT * FROM companies");

		echo "<form method=post id=text_new action=index.php?page=insertCompany> 
			<table id='tableCompany' class='tables'>
			<tr class='tab_footer'>
			<th class='tab_id'>id</th>
			<th>Наименование</th>
			<th class ='tab_adress'>Адрес</th>
			<th class='tab_phone'>Телефон</th>
			<th class='tab_items'>Просмотр продукции</th>
			</tr></form>";
		while($row = mysqli_fetch_array($result))
		{
			$ret[] = $row;
			  echo "<tr class='tab_content'>";
			  echo "<td class='tab_id'>" . $row['id'] . "</td>";
			  echo "<td>" . $row['nameCompany'] . "</td>";
			  echo "<td class='tab_adress'>" . $row['adress'] . "</td>";
			  echo "<td class='tab_phone'>" . $row['phone'] . "</td>";
			  echo "<td><a name=\"view\" href=\"index.php?page=products&action=view&id=".$row["id"]."\"><img src=\"list.ico\" style=\"width: 16px; height: 16px;\">Продукция</a></td>\n";
			  echo "</tr>";
		}
echo "</table>"; 
		return $ret;
	close_bd();
	
	echo $ret;
?>