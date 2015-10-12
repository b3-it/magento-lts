<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customer freecopies product grid block
 *
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * 
 * @see 		http://stackoverflow.com/questions/5373406/add-data-callback-to-grid-via-php-not-xml-is-it-possible-in-magento
 * @see			http://dev.turboweb.co.nz/2011/04/16/creating-a-magento-admin-fully-editable-grid/ 
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Freecopies_Report extends Mage_Adminhtml_Block_Widget_Grid
{
	protected $_customer = null;
	
	/**
	 * Get current customer
	 * 
	 * @return Mage_Customer_Model_Customer
	 */
	protected function _getCustomer() {
		if (!$this->_customer) {
			$this->_customer = Mage::registry('current_customer');
		}
		
		return $this->_customer;
	}
	
    /**
     * Initialize block
     *
     */
	public function __construct()
    {
        parent::__construct();
        $this->setId('freecopies_product_report_grid');
        $this->setDefaultSort('product_id');
        $this->setUseAjax(true);
        $this->setIdFieldName('product_id');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
    	/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
    	$collection = Mage::getModel('extcustomer/freecopies')->getCollection();
    	$collection->addFieldToFilter('customer_id',
    		array(
    			array($this->_getCustomer()->getId()),
    		)
    	);
    	
		$collection->selectProductFieldsAboReport($this->_getCustomer()->getId());
		
        $this->setCollection($collection);

        try {
        	parent::_prepareCollection();       	
        } catch (Exception $e) {
        	$this->setCollection(new Varien_Data_Collection());
        	Mage::log($this->__('Error while loading freecopies: %s', $e->getMessage()), Zend_Log::WARN, Egovs_Helper::EXCEPTION_LOG_FILE);
        	$this->getLayout()->getMessagesBlock()->addWarning($this->__('There was an error while loading freecopies, please reload the whole page.'));
        	$this->getAction()->getResponse()->setBody($this->getLayout()->getMessagesBlock()->toHtml())
        		->sendResponse()
        	;
        	exit;
    	}

        return $this;
    }

    protected function _prepareColumns()
    {
    	$index = 'product_entity_id';

        $this->addColumn('product_id', array(
            'header'    	=> Mage::helper('catalog')->__('ID'),
        	'name'			=> 'product_id',
            'sortable'  	=> true,
            'width'     	=> '60px',
        	'editable'		=> false,
        	'filter_index' 	=> '`catalog/product`.entity_id',
            'index'     	=> $index
        ));
        
        $this->addColumn('name', array(
            'header'    	=> Mage::helper('catalog')->__('Name'),
        	'filter_index'	=> 'e1.value',
            'index'     	=> 'name'
        ));

    	$model = Mage::getSingleton('stalaproduct/nature');
        if ($model) {
        	$options = $model->getOptionArray();
        
        	if (count($options) > 0) {
        		$this->addColumn('artikel_art',
        		array(
        				'header'		=> 'Artikel Art',
                		'width' 		=> '100px',
                		'index' 		=> 'article_type',
        				'filter_index'	=> 'e3.value',
                		'type'  		=> 'options',
        				'options' =>$options,
        		));
        	}
        }

        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80px',
            'index'     => 'sku'
        ));
        $this->addColumn('price', array(
        	'name'			=> 'price',
            'header'    	=> Mage::helper('catalog')->__('Price'),
            'type'  		=> 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
        	'filter_index'	=> 'e.value',
            'index'     	=> 'price'
        ));

        
		$this->addColumn('base_freecopies', array(
            'header'    => Mage::helper('extcustomer')->__('Base Freecopies'),
            'name'      => 'base_freecopies',
            'width'     => '40px',
            'type'      => 'number',
            'index'     => 'base_freecopies',
        ));
        
        
        $this->addColumn('freecopies', array(
            'header'    => Mage::helper('extcustomer')->__('Freecopies'),
            'name'      => 'freecopies',
            'width'     => '60px',
            'type'      => 'number',
            'validate_class' => 'validate-number',
            'index'     => 'freecopies',
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/report', array('_current'=>true));
    }
}
