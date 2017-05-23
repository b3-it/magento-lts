<?php
class Bkg_Geometry_Point extends Bkg_Geometry_Geometry
{
	protected $_x = '0.0';
	protected $_y = '0.0';

	
	public function getX()
	{
		return $this->_x;
	}
	
	public function getY()
	{
		return $this->_y;
	}
	
	public function setX($value)
	{
		$this->_x = $value;
		return $this;
	}
	
	public function setY($value)
	{
		$this->_y;
		return $this;
	}
	
	public function toString($format = Bkg_Geometry_Format::RAW)
	{
		$res = $this->_x .' ' .$this->_y;
		if($format == Bkg_Geometry_Format::WKT){
			return "POINT(".$res.")";
		}
		return $res;
	}
	
	public function toSql()
	{
		return new Zend_Db_Expr("(PointFromText('".$this->toString(Bkg_Geometry_Format::WKT)."'))");
	}
	
	public function load($data, $format = Bkg_Geometry_Format::RAW)
	{
		if(!is_array($data)){
			$data = trim($data);
			$data = explode(' ', $data);
		}
		
		$this->_x = array_shift($data);
		$this->_y = array_shift($data);
		return $this;
	}
	
}