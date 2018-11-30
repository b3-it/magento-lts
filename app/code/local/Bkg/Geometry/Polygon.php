<?php
class Bkg_Geometry_Polygon extends Bkg_Geometry_Geometry
{
	/**
	 * 
	 * @var Bkg_Geometry_LineString
	 */
	protected $_exterior;
	
	/**
	 *
	 * @var array Bkg_Geometry_Linstring
	 */
	protected $_interior = array();
	
	
	public function getInterior()
	{
		return $this->_interior;
	}
	
	public function setInterior($linestrings)
	{
		$this->_interior = $linestrings;
		return $this;
	}
	
	public function addInterior($linestring)
	{
		$this->_interior[] = $linestring;
		return $this;
	}
	
	public function getExterior()
	{
		return $this->_exterior;
	}
	
	public function setExterior($linestring)
	{
		$this->_exterior = $linestring;
		return $this;
	}
	
	public function load($data, $format = Bkg_Geometry_Format::RAW)
	{
		$linestring = new Bkg_Geometry_LineString();
		$linestring->load($data);
		
		$this->setExterior($linestring);
		
		return $this;
	}
	
	public function toString($format = Bkg_Geometry_Format::RAW)
	{
		$res = array();
		$res[] = $this->_exterior->toString();
		foreach($this->_interior as $line){
			$res[] = $line->toString();
		}
		
		$res = implode(',', $res);
		
		$res = '('.$res.')';
		
		
		if($format == Bkg_Geometry_Format::WKT)
		{
			$res = 'POLYGON'.$res;
		}
		
		
		return $res;
	}
	
	public function toSql()
	{
		$sql = "(PolygonFromText('".$this->toString(Bkg_Geometry_Format::WKT)."'))";
		return new Zend_Db_Expr($sql);
	}
}