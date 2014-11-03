<?php
/*echo $_SERVER["REQUEST_URI"];
die(0);*/


function __autoload($classname)
{
	$path = str_replace('_', DIRECTORY_SEPARATOR, $classname);
	include($classname.'.php');
}
/* Получаем запрос, удаляя пробелы и слеши
// в начале и конце строки
$request = trim($_SERVER["REQUEST_URI"], '/');
 
// Разбиваем запрос на части
$parts = explode('/', $request);
 
// Удаляем случайные пустые элементы, которые
// появляются, если, например, в запросе будет
// два слеша подряд (/news//04/01/1986/)
$parts = array_filter($parts, 'trim');
 
// Смотрим результат
print_r($parts);*/
?>

<?php include  "header.php" ; ?>
<?php// include  "sidebar.php"; ?>
<!-- <div id="page"> -->
<!-- <div class="content"> -->

<?php 

$page = @$_GET['page'];
$action = @$_GET['action'];

if($action == null)
{
	\controller\main::view();
}
else 
{
	$p='\controller\\'.$page;
	$i = new $p();
	$i->$action();
}
/*

sphinx php

//$locale = "ru";
//$db_connection = connect();
//$company_model = new \App\Model\CompanyModel($db_connection, $locale);

// route - роутинг
// .htaccess - apache mod_rewrite
// site.ru/index.php?action=123 ведет на www.site.ru/index.php?action=123   - то есть 301 серверный редирект
// www.site.ru/companies/id/56/ - страница компании
// www.site.ru/companies/delete/id/56/ - удалить страницу компании
// apache/conf/extra/vhosts - сюда можно прописать виртуальный хост типа site.ru только потом потребуется еще C:/windows/system32/drivers/etc/hosts сделать запись 127.0.0.1 site.ru

// добавить продукт-------------------------------------------------------------------------------------------------------
// нажимаем f5 - запрос идет повторно - получается один продукт добавляется дважды
// защита: post-redirect-get-----------------------------------------------------------------------------------------------

   */

?>
</div>
</div>
<div class="clr"></div>
</div>
</body>
</html>

