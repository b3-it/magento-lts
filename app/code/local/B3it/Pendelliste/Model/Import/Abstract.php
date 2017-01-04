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
abstract class  B3it_Pendelliste_Model_Import_Abstract extends Varien_Object
{
    protected $_data = null;
    
    public function setData($data)
    {
    	$this->_data = $data;
    	return $this;
    }
    
    public function getData()
    {
    	return $this->_data;
    }
    
    
    public abstract function import();
    
    
    public static function create($model,$modelParams,$data)
    {
    	$model = null;
    	
    	
    	switch ($model)
    	{
    		case 'core_config_data': 
    			$model = Mage::getModel('pendelliste/import_coreConfigData');
    			break;
    		
    	}
    	
    	if($model != null ){
    		$model->setData($data);
    	}
    	
    	return $model;
    }
    
}