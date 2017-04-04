<?php
class Bkg_Geometry_Abstract
{
	
	
	public function toString()
	{
		throw new Exception('Abstract Method');
	}
	
	public function toSql()
	{
		throw new Exception('Abstract Method');
	}
	
	
	public function load($data)
	{
		throw new Exception('Abstract Method');
	}
}