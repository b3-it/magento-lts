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
    
    public function setModelData($data)
    {
    	$this->_data = $data;
    	return $this;
    }
    
    public function getModelData()
    {
    	return $this->_data;
    }
    
    protected $_params = null;
    
    public function setParams($data)
    {
    	$this->_params = $data;
    	return $this;
    }
    
    public function getParams()
    {
    	return $this->_params;
    }
    
    
    public abstract function import();
    
    
    public static function create($modelName,$modelParams,$data,$params)
    {
    	$model = null;
    	
    	
    	switch ($modelName)
    	{
    		case 'core_config_data': 
    			$model = Mage::getModel('pendelliste/import_coreConfigData');
    			break;
    		
    	}
    	
    	if($model != null ){
    		$model->setModelData($data);
    		$model->setParams($params);
    	}
    	
    	return $model;
    }
    
}