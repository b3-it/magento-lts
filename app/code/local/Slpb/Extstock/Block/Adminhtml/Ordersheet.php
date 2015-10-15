<?php
class Slpb_Extstock_Block_Adminhtml_Ordersheet extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{

		$this->_controller = 'adminhtml_ordersheet';
		$this->_blockGroup = 'extstock';
		$this->_headerText = Mage::helper('extstock')->__('Stock Order # %s',$this->getRequest()->getParam('lieferid'));

		parent::__construct();
		$this->removeButton('add');

		
		$this->_addButton('back', array(
            'label'     => Mage::helper('adminhtml')->__('Back'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/adminhtml_stockorder/index') . '\')',
            'class'     => 'back',
        ), -1);

        $lieferid = $this->getRequest()->getParam('lieferid');
		$this->_addButton('print', array(
            'label'     => Mage::helper('adminhtml')->__('Print'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/adminhtml_ordersheet/print',array('lieferid'=>$lieferid)) . '\')',
            'class'     => 'add',
        ), -1);
		
	}
	
  
}