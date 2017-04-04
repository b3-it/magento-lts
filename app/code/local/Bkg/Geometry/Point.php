<?php
class Bkg_Geometry_Point extends Bkg_Geometry_Abstract
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
	
	public function toString()
	{
		return $this->_x .' ' .$this->_y;
	}
	
	public function toSql()
	{
		return new Zend_Db_Expr("(PointFromText('POINT(".$this->toString().")'))");
	}
	
	public function load($data)
	{
		if(is_array($data)){
			$this->_x = array_shift($data);
			$this->_y = array_shift($data);
			return $this;
		}
		
		$data = explode(' ', $data);
		$this->_x = array_shift($data);
		$this->_y = array_shift($data);
		return $this;
	}
	
}