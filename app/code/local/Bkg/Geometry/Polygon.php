<?php
class Bkg_Geometry_Polygon 
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
}