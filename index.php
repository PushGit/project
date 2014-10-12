<?php 
function __autoload($classname)
{
	$path = str_replace('_', DIRECTORY_SEPARATOR, $classname);
	include($classname.'.php');
}
?>

<?php include  "header.php" ; ?>
<?php include  "sidebar.php"; ?>

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


jquery.ajax--------------------------------------------------------------
поиск без перезагрузки страницы

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

// в форме редактирования продукта добавить заливку картинки (ок). Понятно, что файл придется хранить физически на диске и удалять при удалении продукта
// библиотека GD  в PHP - при заливке картинки нужно сделать ее миниатюры: малая 80х80, средняя 200х200 и большая 600х600
// на странице продукта картинки можно пролистать с помощью jQuery lightBox
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// добавить продукт-------------------------------------------------------------------------------------------------------
// нажимаем f5 - запрос идет повторно - получается один продукт добавляется дважды
// защита: post-redirect-get-----------------------------------------------------------------------------------------------

   */
/*
вопросы:

адреса типа www.site.ru/companies/id/56/
mod_rewrite

*/
?>
</div>
</div>
<div class="clr"></div>
</div>
</body>
</html>

