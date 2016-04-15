<?php
/**
 * Adminhtml customer freecopies product grid block
 *
 * Grid für Freiexemplare (FE)
 * 
 * JA => Individuelle FE werden angezeigt
 * NEIN => Globale FE werden angezeigt
 * ALLE => ALLE Produkte werden angezeigt
 * 
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * 
 * @see 		http://stackoverflow.com/questions/5373406/add-data-callback-to-grid-via-php-not-xml-is-it-possible-in-magento
 * @see			http://dev.turboweb.co.nz/2011/04/16/creating-a-magento-admin-fully-editable-grid/ 
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Freecopies_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('freecopies_product_grid');
        $this->setDefaultSort('product_id');
        $this->setUseAjax(true);
        $this->setIdFieldName('product_id');
        $this->setSaveParametersInSession(true);
//        if ($this->_getProduct()->getId()) {
//            $this->setDefaultFilter(array('in_products'=>1));
//        }
		
        $this->setRowClickCallback('copyGridRowFreecopyValue');
    }

    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('product_id', array('in'=>$productIds));
            }
            else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('product_id', array('nin'=>$productIds));
                } else {
                	$this->getCollection()->addFieldToFilter('product_id', array('notnull'=>true));
                }
            }
        }
        else {
        	parent::_addColumnFilterToCollection($column);
        }
//         Mage::log($this->getCollection()->getSelect()->assemble(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        return $this;
    }

    protected function _prepareCollection()
    {
    	/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
    	$collection = Mage::getModel('extcustomer/freecopies')->getCollection();
    	$collection->addFieldToFilter('customer_id',
    		array(
    			array($this->_getCustomer()->getId()),
    			array('null' => true),
    		)
    	);
//    	$collection->addFilterByCustomerId($this->_getCustomer()->getId());
		$collection->selectProductFields($this->_getCustomer()->getId());
                
    	if ($this->_getCustomer()->getId() && count($this->_getSelectedProducts())) {
			$this->setDefaultFilter(array('in_products' => 1));
		}
		
//		echo $collection->getSelect()->assemble();
        $this->setCollection($collection);

        try {
        	parent::_prepareCollection();       	
        } catch (Exception $e) {
        	$this->setCollection(new Varien_Data_Collection());
        	Mage::log($this->__("Error while loading freecopies: %s\n%s", $e->getMessage(), $e->getTraceAsString()), Zend_Log::WARN, Egovs_Helper::EXCEPTION_LOG_FILE);
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
                
    	$this->addColumn('in_products', array(
	        'header_css_class' => 'a-center',
	        'type'      	=> 'checkbox',
	        'filter'		=> 'extcustomer/adminhtml_widget_grid_column_filter_checkbox',
	        'name'      	=> 'in_products',
	        'values'    	=> $this->_getSelectedProducts(),
	        'align'     	=> 'center',
    		'filter_index' 	=> 'catalog_product.entity_id',
	        'index'     	=> $index,
	        'width'			=> '90px'
        ));

        $this->addColumn('product_id', array(
            'header'    	=> Mage::helper('catalog')->__('ID'),
        	'name'			=> 'product_id',
            'sortable'  	=> true,
            'width'     	=> '60px',
        	'editable'		=> false,
        	'filter_index' 	=> 'catalog_product.entity_id',
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

        if ($this->hasFreecopyProducts()) {
			$this->addColumn('base_freecopies', array(
	            'header'    => Mage::helper('extcustomer')->__('Base Freecopies'),
	            'name'      => 'base_freecopies',
	            'width'     => '40px',
	            'type'      => 'number',
	            'index'     => 'base_freecopies',
	        ));
        }
        
        $this->addColumn('freecopies', array(
            'header'    => Mage::helper('extcustomer')->__('Freecopies'),
            'name'      => 'freecopies',
            'width'     => '60px',
            'type'      => 'number',
            'validate_class' => 'validate-number',
            'index'     => 'freecopies',
            'editable'  => true,
        	'default'	=> 0,
//            'edit_only' => !$this->getSelectedFreecopyProducts()
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/freecopies', array('_current'=>true));
    }

    protected function _getSelectedProducts()
    {
    	$freecopies = $this->getCustomerFreecopies();
        if (!is_array($freecopies)) {
            $freecopies = array_keys($this->getSelectedFreecopyProducts());
        }
        return $freecopies;
    }
    
    public function getSelectedFreecopyProducts() {
    	$freecopies = array();
	    	
    	if ($this->_getCustomer()) {
    		/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
    		$collection = Mage::getModel('extcustomer/freecopies')->getCollection();
    		$collection->addFilterByCustomerId($this->_getCustomer()->getId());
			$collection->addFieldToFilter('option',Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL);

			foreach ($collection->getItems() as $freecopy) {
				$freecopies[$freecopy->getProductId()] = array('freecopies' => $freecopy->getFreecopies(false));
			}
    	}
        return $freecopies;
    }
    
    public function hasFreecopyProducts() {
    	if ($this->_getCustomer()) {
    		/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
    		$collection = Mage::getModel('extcustomer/freecopies')->getCollection();
    		$collection->addFilterByCustomerId($this->_getCustomer()->getId());
    		$collection->getSelect()->limit(1);
    		
    		return  $collection->getSize() > 0 ? true : false; 
    	}
    	
    	return false;
    }
}
