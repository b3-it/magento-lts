<?php
/**
 * 
 *  Abstrakte Klasse füe Models mit Geometrien
 *  @category BKG
 *  @package  Bkg_Geometry_Model_Resource_Abstract
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Bkg_Geometry_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{
   public function loadGeoemetryAsText($id,$field='shape')
   {
   		$read = $this->getReadConnection();
   		$table = $this->_tables[$this->_mainTable];
   		$idField = $this->_idFieldName;
   		$sql = sprintf("SELECT ST_AsText($field) AS geo FROM $table WHERE $idField = $id");
   		$data = $read->fetchRow($sql);
   		
   		if(isset($data['geo']))
   		{
   			return $this->_getGeometry($data['geo']);
   		}
   		
   		return null;
   }
   
   /**
    * Die geometrie anhand des Wkt feststellen und laden
    * @param string $value
    * @return Bkg_Geometry_Geometry | null
    */
   protected function _getGeometry($value)
   {
   		if($value)
   		{
   			preg_match('/(.*?)\(\((.*?)\)\)/', $value, $split);
   			$geo = Bkg_Geometry_Geometry::getGeometryByName($split[1]);
   			$geo->load($split[2]);
   			
   			return $geo;
   		}
   		
   		return null;
   }
   
}
