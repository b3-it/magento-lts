<?php
class Bkg_Geometry_Geometry
{
	
	
	public function toString($format = Bkg_Geometry_Format::RAW)
	{
		throw new Exception('Abstract Method');
	}
	
	public function toSql()
	{
		throw new Exception('Abstract Method');
	}
	
	
	public function load($data, $format = Bkg_Geometry_Format::RAW)
	{
		throw new Exception('Abstract Method');
	}
	
	
	public static function getGeometryByName($name)
	{
		$name = ucfirst($name);
		$class = 'Bkg_Geometry_'.$name;
		return new $class();
	}
	
}