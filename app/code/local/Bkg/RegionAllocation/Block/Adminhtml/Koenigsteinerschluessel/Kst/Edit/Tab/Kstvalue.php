<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Kstvalue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Kstvalue extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_koenigsteinerschluessel_kst_edit_tab_kstvalue';
    $this->_blockGroup = 'regionallocation';
    $this->_headerText = Mage::helper('regionallocation')->__('Region Values');
    $this->_addButtonLabel = Mage::helper('regionallocation')->__('Add Item');
    parent::__construct();
    $kst =	Mage::registry('koenigsteinerschluesselkst_data');
   
    $url = $this->getUrl('*/regionallocation_koenigsteinerschluessel_kstvalue/new',array('kst_id'=>$kst->getId()));
    $url = "setLocation('".$url."');";
    $this->_updateButton('add','onclick',$url );
  }
}
