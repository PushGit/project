<?php 

namespace controller;
use model\user as mUser;
use model\dateBase as dateBase;
use view\products as vProducts;
use view\companies as vCompanies;
use model\products as mProducts;
use model\companies as mCompanies;

class products
{
	public static function view()
	{
		$all=0;
		$data = mProducts::view($all);
		$id = @$_GET["id"];
		if(@$_GET["id"]=="")
		{
			$id=$_COOKIE['companyID'];
		}
		if($id==$_COOKIE['companyID'])
		{
			vProducts::view($data,$all);
		}
		else
		{
			vProducts::viewOther($data,$all);
		}
	}
	public static function viewPic()
	{
		vProducts::viewPic();
	}
	public static function viewAll()
	{
		$all=1;
		$data = mProducts::view($all);
		vProducts::viewOther($data,$all);
	}
	public static function delete()
	{
		mProducts::delete();
	}
	public static function edit()
	{
		mProducts::edit();
	}
	public static function insert()
	{
		mProducts::insert();
	}
}
?>