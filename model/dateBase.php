<?php
namespace model;
use view as view;
use view\main as vMain;
use view\companies as vCompanies;
use view\products as vProducts;

class dateBase
{
	public static function connect()
	{
		$link  = mysqli_connect('localhost', 'root', '435123451', 'companies');
			if (!$link) {
			die('Ошибка соединения: ' . mysqli_error());
		}
		return $link;
	}

	public static function close_bd()
	{
		mysqli_close(dateBase::connect());
	}
}
?>