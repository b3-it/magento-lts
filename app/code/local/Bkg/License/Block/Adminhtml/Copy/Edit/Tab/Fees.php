<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Toll_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Fees extends Mage_Adminhtml_Block_Widget
{
	protected $_values = null;
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/master/edit/tab/fees.phtml');
	}
	
	
    public function getFeesSections()
    {
    	$sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
    	return $sect;
    }

    public function getYesNoOptions($selected)
    {
        $res = array();
        if($selected == 0)
        {
                 $res[] = '<option selected="selected" value="0">'.$this->__('No').'</option>';
        }else
            {
                $res[] ='<option value="0">'.$this->__('No').'</option>';
            }

        if($selected == 1)
        {
            $res[] = '<option selected="selected" value="1">'.$this->__('Yes').'</option>';
        }else
        {
            $res[] ='<option value="1">'.$this->__('Yes').'</option>';
        }

    return implode(' ',$res);

    }


    public function getValues($section)
    {
        if($this->_values== null)
        {
            $collection = Mage::getModel('bkg_license/copy_fee')->getCollection();
            $collection->getSelect()->where('copy_id ='. intval(Mage::registry('entity_data')->getId()));
            $this->_values = $collection->getItems();

        }

        foreach($this->_values as $item)
        {
            if($item->getFeeCode() == $section)
            {
                return $item;
            }
        }

        return new Varien_Object();

    }
   
}
