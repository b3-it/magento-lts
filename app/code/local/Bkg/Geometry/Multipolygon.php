<?php
class Bkg_Geometry_Multipolygon extends Bkg_Geometry_Geometry
{
	/**
	 * 
	 * @var Bkg_Geometry_Polygon[] $_polygons
	 */
	protected $_polygons = array();
	
	public function getPolygons()
	{
		return $this->_polygons;
	}
	
	public function setPolygon($polygons)
	{
	    $this->_polygons = $polygons;
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
			$res[] = $polygon->toString();
		}
		
		$res = implode(',', $res);
		
		$res = '('.$res.')';
		
		if($format == Bkg_Geometry_Format::WKT)
		{
			$res = 'MULTIPOLYGON'.$res;
		}
		
		
		return $res;
	}
	
	public function toSql()
	{
		$txt = "(MultiPolygonFromText('".$this->toString(Bkg_Geometry_Format::WKT)."'))";
		return new Zend_Db_Expr($txt);
	}
}