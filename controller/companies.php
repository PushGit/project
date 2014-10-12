<?php 
namespace controller;
use view\companies as vCompanies;
use model\companies as mCompanies;

class companies
{
	public static function view()
	{
		$data = mCompanies::view();
		vCompanies::view($data);
	}
	public static function edit()
	{
		mCompanies::edit();
	}
	public static function delete()
	{
		 mCompanies::delete();
	}

	public static function insert()
	{	
		mCompanies::insert();	
	}
}
?>