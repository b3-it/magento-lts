<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Block_Adminhtml_Tax_Rule_Grid extends Mage_Adminhtml_Block_Tax_Rule_Grid
{

    protected function _prepareColumns()
    {
    	parent::_prepareColumns();
    	
    	$opt = Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray();
        
        $this->addColumnAfter('valid_taxvat',
        		array(
        				'sortable'  => false,
        				'header'  => Mage::helper('germantax')->__('Recipient Valid Tax Vat Only'),
        				'align'   => 'left',
        				'index'   => 'valid_taxvat',
        				//'filter_index' => 'rate.tax_calculation_rate_id',
        				'type'    => 'options',
        				'width' =>130,
        				//'show_missing_option_values' => true,
        				'options' => $opt
        		),
        		'product_tax_classes'
        );

        return $this;
    }

 

}
