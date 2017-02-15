<?php
/**
 *  Statusklasse für Pendelliste
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class  B3it_Pendelliste_Model_Import_CoreConfigData extends B3it_Pendelliste_Model_Import_Abstract
{
  public function import()
  {
  	if(isset($this->_data))
  	{
  		$path = $this->_params->params;
  		$conf = Mage::getModel('core/config_data')->load($path,'path');
  		$conf->setValue($this->_data->data);
  		$conf->save();
  		return $conf->getId();
  	}
  
  	return null;
  }
}