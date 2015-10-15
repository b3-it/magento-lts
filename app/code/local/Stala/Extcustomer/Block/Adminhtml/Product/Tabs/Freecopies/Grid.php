<?php
/**
 * Adminhtml product cross freecopies product grid block
 *
 * Grid für Cross-Freiexemplare (FE)
 * 
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * 
 * @see 		http://stackoverflow.com/questions/5373406/add-data-callback-to-grid-via-php-not-xml-is-it-possible-in-magento
 * @see			http://dev.turboweb.co.nz/2011/04/16/creating-a-magento-admin-fully-editable-grid/ 
 */
class Stala_Extcustomer_Block_Adminhtml_Product_Tabs_Freecopies_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	protected $_product = null;
	
	/**
	 * Get current edited product
	 * 
	 * @return Mage_Catalog_Model_Product
	 */
	protected function _getProduct() {
		if (!$this->_product) {
			$this->_product = Mage::registry('current_product');
		}
		
		return $this->_product;
	}
	
    /**
     * Initialize block
     *
     */
	public function __construct()
    {
        parent::__construct();
        $this->setId('crossfreecopies_product_grid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
//         $this->setIdFieldName('product_id');
        $this->setSaveParametersInSession(true);
       if ($this->_getProduct()->getId()) {
           $this->setDefaultFilter(array('in_products'=>1));
       }
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
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                } /* else {
                	$this->getCollection()->addFieldToFilter('entity_id', array('notnull'=>true));
                } */
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
    	$collection = Mage::getModel('extcustomer/product_link')->useCrossFreecopiesLinks()
            ->getProductCollection()
            ->setProduct($this->_getProduct())
            ->addAttributeToSelect('*');

        /* if ($this->isReadonly()) {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = array(0);
            }
            $collection->addFieldToFilter('entity_id', array('in'=>$productIds));
        } */
		
		$this->setCollection($collection);
		
        parent::_prepareCollection();
        
        Mage::log($collection->getSelect()->assemble(), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
        
        return $this;
    }

    protected function _prepareColumns()
    {
    	$index = 'entity_id';
                
    	$this->addColumn('in_products', array(
	        'header_css_class' => 'a-center',
	        'type'      	=> 'checkbox',
	        'name'      	=> 'in_products',
	        'values'    	=> $this->_getSelectedProducts(),
	        'align'     	=> 'center',
//     		'filter_index' 	=> '`catalog/product`.entity_id',
	        'index'     	=> $index,
	        'width'			=> '90px'
        ));

        $this->addColumn('entity_id', array(
            'header'    	=> Mage::helper('catalog')->__('ID'),
        	'name'			=> 'entity_id',
            'sortable'  	=> true,
            'width'     	=> '60px',
        	'editable'		=> false,
            'index'     	=> $index
        ));
        
        $this->addColumn('name', array(
            'header'    	=> Mage::helper('catalog')->__('Name'),
            'index'     	=> 'name',
//             'editable'		=> false
        ));

        $model = Mage::getSingleton('stalaproduct/nature');
        if ($model) {
        	$options = $model->getOptionArray();
        
        	if (count($options) > 0) {
        		$this->addColumn('artikel_art',
        		array(
        				'header'		=> 'Artikel Art',
                		'width' 		=> '100px',
        				'index' 		=> 'artikel_art',
                		'type'  		=> 'options',
        				'options'		=>	$options,
        		));
        	}
        }
        
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80px',
            'index'     => 'sku'
        ));
        
        $this->addColumn('status',
        array(
                        'header'=> Mage::helper('catalog')->__('Status'),
                        'width' => '90px',
                        'index' => 'status',
                        'type'  => 'options',
                        'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
        
        $this->addColumn('visibility',
        array(
                        'header'=> Mage::helper('catalog')->__('Visibility'),
                        'width' => '90px',
                        'index' => 'visibility',
                        'type'  => 'options',
                        'options' => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));
        
        $this->addColumn('price', array(
        	'name'			=> 'price',
            'header'    	=> Mage::helper('catalog')->__('Price'),
            'type'  		=> 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     	=> 'price'
        ));
        
        //Der Name muss mit dem Namen in der Layout XML Datei übereinstimmen!
        //ist hier nur dummy da sonst das JS nicht korrekt arbeitet
        //Falls es Probleme mit der Ansicht gibt, sollte diese Spalte nicht als letztes stehen!
        $this->addColumn('dummy_input', array(
                            'name'      => 'dummy_input',
                            'width'     => '0px',
                            'index'     => $index, //es sollen die Product IDs drin stehen
                            'renderer'		=> 'extcustomer/adminhtml_widget_grid_column_renderer_hidden',
                            'filter'		=> 'extcustomer/adminhtml_widget_grid_column_filter_hidden',
                            'header_css_class'	=> 'no-display ', //header
                            'column_css_class'	=> 'no-display ', //body,footer
        ));
        
        return parent::_prepareColumns();
    }
    
    protected function _beforeToHtml() {
    	/* if ($this->getCollection())
    		Mage::log($this->getCollection()->getSelect()->assemble(), Zend_Log::DEBUG, Stala_Helper::LOG_FILE); */
    	return parent::_beforeToHtml();    	
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/freecopies', array('_current'=>true));
    }

    protected function _getSelectedProducts()
    {
    	$freecopies = $this->getProductCrossFreecopies();
        if (!is_array($freecopies)) {
            $freecopies = array_keys($this->getSelectedFreecopyProducts());
            $this->setProductCrossFreecopies($freecopies);
        }
        return $freecopies;
    }
    
    public function getSelectedFreecopyProducts() {
    	$freecopies = array();
	    	
    	/* @var $crossFreecopies Stala_Extcustomer_Model_Product_Link */
		$crossFreecopies = Mage::getModel('extcustomer/product_link');
		
		if (!$crossFreecopies)
			return $freecopies;

		$crossFreecopies->useCrossFreecopiesLinks();
		$collection = $crossFreecopies->getLinkCollection();
		$collection->addFieldToFilter('`product_id`',$this->_getProduct()->getId());
		$collection->addFieldToFilter('`link_type_id`',$crossFreecopies->getLinkTypeId());

		foreach ($collection->getItems() as $linkedProduct) {
			////hier muss dummy input Feld stehen, sonst spinnt JS
			//Der Name muss mit dem Namen in der Layout XML Datei übereinstimmen!
			$freecopies[$linkedProduct->getLinkedProductId()] = array('dummy_input' => true);
		}
		
        return $freecopies;
    }
}
