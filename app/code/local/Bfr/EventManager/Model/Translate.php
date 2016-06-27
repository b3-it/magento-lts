<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Translate
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Translate extends Mage_Core_Model_Abstract
{
	private $_translateCollection = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/translate');
    }
    
    public function getTranslateCollection($LangCode)
    {
    	if($this->_translateCollection == null){
    		$this->_translateCollection = array();
    		$collection = $this->getCollection();
    		$collection->getSelect()
    			->where("lang_code = '".$LangCode."'");
    		foreach($collection->getItems() as $item)
    		{
    			if(!isset($this->_translateCollection[$item->getField()])){
    				$this->_translateCollection[$item->getField()] = array('search'=>array(),'replace'=>array());
    			}
    			$this->_translateCollection[$item->getField()]['search'][] = $item->getSource();
    			$this->_translateCollection[$item->getField()]['replace'][] = $item->getDest();
    		}
    	}
    	return $this->_translateCollection;
    }
    
    /**
     * Übersetzt alle Felder in object 
     * @param Varien_Object $object das 
     * @param array $fields die zu übersetztenden Felder
     * @param string $LangCode die Zielsprache
     */
    public function translateData($object,$fields,$LangCode)
    {
    	$trans = $this->getTranslateCollection($LangCode);
    	foreach($fields as $field)
    	{
    		$data = trim($object->getData($field));
    		if($data){
    			if(isset($trans[$field])){
	    			$data = str_replace($trans[$field]['search'], $trans[$field]['replace'], $data);
	    			$object->setData($field,$data);
    			}
    		}
    	}
    }
    
    
}
