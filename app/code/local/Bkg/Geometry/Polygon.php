<?php
class Bkg_Geometry_Polygon extends Bkg_Geometry_Geometry
{
	/**
	 * 
	 * @var array Bkg_Geometry_Point
	 */
	protected $_points = array();
	
	public function getPoints()
	{
		return $this->_points;
	}
	
	public function setPoints($points)
	{
		$this->_points = $points;
		return $this;
	}
	
	public function addPoint($point)
	{
		$this->_points[] = $point;
		return $this;
	}
	
	public function load($data, $format = Bkg_Geometry_Format::RAW)
	{
		$data = explode(',', $data);
		
		foreach($data as $d){
			$p = new Bkg_Geometry_Point();
			$p->load($d);
			$this->addPoint($p);
		}
		
		return $this;
	}
	
	public function toString($format = Bkg_Geometry_Format::RAW)
	{
		$res = array();
		foreach($this->_points as $point){
			$res[] = $point->toString();
		}
		
		return implode(',', $res);
	}
	
	public function toSql()
	{
		$sql = "(PolygonFromText('POLYGON((".$this->toString()."))'))";
		return new Zend_Db_Expr($sql);
	}
}