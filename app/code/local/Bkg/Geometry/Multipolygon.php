<?php
class Bkg_Geometry_Multipolygon extends Bkg_Geometry_Geometry
{
	/**
	 * 
	 * @var array Bkg_Geometry_Multipolygon
	 */
	protected $_polygons = array();
	
	public function getPolygons()
	{
		return $this->_polygons;
	}
	
	public function setPolygon($polygons)
	{
		$this->_polygons = $points;
		return $this;
	}
	
	public function addPoloygon($polygon)
	{
		$this->_polygons[] = $polygon;
		return $this;
	}
	
	public function load($data, $format = Bkg_Geometry_Format::RAW)
	{
		throw new Exception('Not implemented yet!');
	}
	
	public function toString($format = Bkg_Geometry_Format::RAW)
	{
		$res = array();
		foreach($this->_polygons as $polygon){
			$res[] = '('. $polygon->toString() .')';
		}
		
		return implode(',', $res);
	}
	
	public function toSql()
	{
		$txt = "(MultiPolygonFromText('MULTIPOLYGON((".$this->toString()."))'))";
		return new Zend_Db_Expr($txt);
	}
}