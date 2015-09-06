<?php
class Slpb_Extstock_Block_Adminhtml_Extstock_Overview extends Mage_Adminhtml_Block_Widget_Form
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	protected function _prepareForm()
	{
		$this->setForm(new Varien_Data_Form());

		$form = $this->getForm();
		
		$fieldset = $form->addFieldset('extstock_form', array(
			'legend'=>Mage::helper('extstock')->__('Stock overview')
		));

//		$storeCurrency = Mage::app()->getStore()->getBaseCurrencyCode();
		
		$fieldset->addField('total_quantity', 'label', array(
	          'label'     => Mage::helper('extstock')->__('Total quantity'),
		));
		
		$fieldset->addField('lagerwert', 'label', array(
	          'label'     => Mage::helper('extstock')->__('Total cost price'),
//			'note'	=> "[$storeCurrency]"
		));
		
		$fieldset->addField('bestellwert', 'label', array(
	          'label'     => Mage::helper('extstock')->__('Total order price'),
//			'note'	=> "[$storeCurrency]"
		));		
		
		//Daten laden
		$data = array();
		
		$coll = Mage::getModel('extstock/extstock')->getCollection();
		$table = $coll->getTable('extstock');
		$select = $coll->getSelect()->reset()
						->from($table, array('lagerwert'=>new Zend_Db_Expr('SUM(quantity * price)'), 'total_quantity' => 'SUM(quantity)'))						
		;
		
//		print($select->assemble());
		$fetch = Mage::getModel('extstock/extstock')->getCollection()->getConnection()->fetchAll($select);
		
		if (is_array($fetch) && count($fetch) > 0 ) {
			$data['lagerwert'] = Mage::app()->getStore()->formatPrice($fetch[0]['lagerwert'], false);
			$data['total_quantity'] = $fetch[0]['total_quantity'];
		}
		$select = $select->reset()
						->from($table, array('status', 'bestellwert'=>'(quantity_ordered * price)'))
						->where('status = 1')						
		;
		
		$fetch = Mage::getModel('extstock/extstock')->getCollection()->getConnection()->fetchAll($select);
		
		try {
			$data['bestellwert'] = 0;
			foreach ($fetch as $item) {
			 	$data['bestellwert'] += $item['bestellwert'];
			}
			$data['bestellwert'] = Mage::app()->getStore()->formatPrice($data['bestellwert'], false);
		} catch (Exception $e) {
			//Mage::log
		}
		
		$form->setValues($data);		
		
		return parent::_prepareForm();
	}

	protected function _prepareLayout()
	{	
		return parent::_prepareLayout();
	}
}