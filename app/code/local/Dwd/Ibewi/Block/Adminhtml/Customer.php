<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Block_Adminhtml_Customer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customer';
    $this->_blockGroup = 'ibewi';
    $this->_headerText = Mage::helper('ibewi')->__('Customers');
    
    parent::__construct();
    $this->removeButton('add');
  }
  
  public function getButtonId($button)
  {
  		$bt = $this->_children['grid'];
  		if($bt)
  		{
  			$bt = $bt->_children[$button];
  			if($bt)
  			{
  				$id = $bt->getId();
  				return $id;
  			}
  		}
  		return "id";
  }
}