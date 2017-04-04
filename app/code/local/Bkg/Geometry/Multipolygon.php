<?php
class Bkg_Geometry_Multipolygon extends Bkg_Geometry_Abstract
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
	
	public function load($data)
	{
		throw new Exception('Not implemented yet!');
	}
	
	public function toString()
	{
		$res = array();
		foreach($this->_polygons as $polygon){
			$res[] = '('. $polygon->toString() .')';
		}
		
		return implode(',', $res);
	}
	
	public function toSql()
	{
		return new Zend_Db_Expr("(MultiPolygonFromText('MULTIPOLYGON(".$this->toString().")'))");
	}
}