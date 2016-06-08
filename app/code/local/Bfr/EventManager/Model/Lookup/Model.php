<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Lookup_Model extends Varien_Object
{
    private $collection = null;
	protected $typ = 0;
	
	public function setTyp($type = 0)
	{
		$this->typ = $type;
		return $this;
	}
	
	
	public function getCollection()
	{
		if($this->collection == null){
			$this->collection = Mage::getModel('eventmanager/lookup')->getCollection();
			$this->collection->getSelect()
				->where('typ='.$this->typ)
				->order('value');
		}
		return $this->collection;
	}
	

    public function getOptionArray()
    {
    	$res =array();
    	foreach($this->getCollection()->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getValue();
    	}
        return $res;
    }

    /**
	 * Retrieve option array with empty value
	 *
	 * @return array
	 */
	public function getAllOption()
	{
	  $options = self::getAllOptions();
	  array_unshift($options, array('value'=>'', 'label'=>''));
	  return $options;
	}

	/**
	 * Retrieve option array with empty value
	 *
	 * @return array
	 */
	public function getAllOptions($appendEmpty = true)
	{
	  $res = array();
	  if($appendEmpty){
		  $res[] =  array(
		          'value' => '',
		          'label' => Mage::helper('eventmanager')->__('-- Please Select --')
		      );
	  }
	  foreach (self::getOptionArray() as $index => $value) {
	    $res[] = array(
	        'value' => $index,
	        'label' => $value
	    );
	  }
	  return $res;
	}

	/**
	 * Retrieve option text by option value
	 *
	 * @param string $optionId
	 * @return string
	 */
	public function getOptionText($optionId)
	{
	  $options = self::getOptionArray();
	  return isset($options[$optionId]) ? $options[$optionId] : null;
	}

}
