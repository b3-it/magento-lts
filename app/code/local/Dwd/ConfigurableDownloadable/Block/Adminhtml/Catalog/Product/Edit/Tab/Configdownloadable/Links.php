<?php
/**
 * Configurable Downloadable Products Links Block
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Configdownloadable_Links extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Purchased Separately Attribute cache
	 *
	 * @var Mage_Catalog_Model_Resource_Eav_Attribute
	 */
	protected $_purchasedSeparatelyAttribute = null;
	
    /**
     * Class constructor
     * 
     * @param array $attributes Attribute
     *
     * @return void
     */
    public function __construct($attributes=array()) {
    	parent::__construct($attributes);
    	$this->unsetData('row_click_callback');
        $this->setCanEditPrice(false);
        $this->setCanReadPrice(true);
        $this->setNoFilterMassactionColumn(true);
        
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setId('configDownloadableLinksGrid');
    }
    
    protected function _prepareCollection() {
    	$collection = Mage::getModel('configdownloadable/extendedlink')->getCollection();
    	/* @var $collection Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink_Collection */
    	$collection->addFieldToSelect(array('number_of_downloads', 'is_shareable', 'link_file', 'created_at', 'updated_at'));
    	$collection->addFieldToFilter('link_type', 'file');
    	$collection->addProductToFilter($this->getProduct())
    			->addTitleByProductToResult(0, $this->getProduct()->getId())
    			->addPriceByProductToResult(null, $this->getProduct()->getId())
    	;
    	
    	$this->setCollection($collection);
    	return parent::_prepareCollection();
    }
    
    /**
     * Columns definieren
     * 
     * @return Dwd_ConfigurableDownloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Configdownloadable_Links
     * 
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareColumns()
     */
    protected function _prepareColumns() {
    	$this->addColumn('title', array(
    			'header'    => Mage::helper('downloadable')->__('Title'),
    			'index'     => 'title',
    			'filter_condition_callback' => array($this, '_filterTitleCondition'),
    	));
    	
    	$this->addColumn('price', array(
    			'header'    => Mage::helper('downloadable')->__('Price'),
    			'index'     => 'price',
    			'type'		=> 'price',
    			'currency_code' => $this->_getStore()->getBaseCurrency()->getCode(),
    			'filter_condition_callback' => array($this, '_filterPriceCondition'),
    	));
    	
    	$this->addColumn('number_of_downloads', array(
    			'header'    => Mage::helper('downloadable')->__('Max. Downloads'),
    			'index'     => 'number_of_downloads',
    			'type'		=> 'number',
    			'width'		=> '105',
    			'renderer'  => 'configdownloadable/adminhtml_widget_grid_column_renderer_numberOfDownloads',
    			'filter'	=> 'configdownloadable/adminhtml_widget_grid_column_filter_numberOfDownloads',
    	));
    	
    	$options = array(
    			1 => Mage::helper('downloadable')->__('Yes'),
    			0 => Mage::helper('downloadable')->__('No'),
    			2 => Mage::helper('downloadable')->__('Use config'),
    	);
    	$this->addColumn('is_shareable', array(
    			'header'    => Mage::helper('downloadable')->__('Shareable'),
    			'index'     => 'is_shareable',
    			'type'		=> 'options',
    			'options'	=> $options
    	));
    	
    	$this->addColumn('created_at', array(
    			'header'    => Mage::helper('configdownloadable')->__('Created at'),
    			'index'     => 'created_at',
    			'align'     => 'center',
    			'type'		=> 'datetime',
    	));
    	
    	$this->addColumn('updated_at', array(
    			'header'    => Mage::helper('configdownloadable')->__('Updated at'),
    			'index'     => 'updated_at',
    			'align'     => 'center',
    			'type'		=> 'datetime',
    	));
    	
    	$this->addColumn('file_name', array(
    			'header'    => Mage::helper('configdownloadable')->__('Path'),
    			'index'     => 'link_file',
    	));
    	
    	$this->addColumn('file', array(
    			'header'    => Mage::helper('downloadable')->__('File'),
    			'index'     => 'link_file',
    			'type'		=> 'action',
    			'renderer'    => 'configdownloadable/adminhtml_widget_grid_column_renderer_downloadAction',
    			'actions'   => array(
    					array(
//     							'caption'   => Mage::helper('downloadable')->__('File'),
    							'url'       => true,
    							'target'	=> '_blank',
    					)
    			),
    			'filter'    => false,
    			'sortable'  => false,
    			'index'     => 'stores',
    			'is_system' => true,
    	));
    }
    
    /**
     * Mass Action
     * 
     * @return Dwd_ConfigurableDownloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Configdownloadable_Links
     * 
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareMassaction()
     */
    protected function _prepareMassaction() {
    	$this->setMassactionIdField('link_id');
    	$this->getMassactionBlock()->setFormFieldName('link_ids');
    	$this->getMassactionBlock()->addItem('delete', array(
    			'label'=> Mage::helper('adminhtml')->__('Delete'),
    			'url'  => $this->getUrl('configdownloadable/adminhtml_configdownloadable_product_edit/massDelete', array('id' => $this->getProduct()->getId(), '_secure' => true)),
    			'confirm' => Mage::helper('adminhtml')->__('Are you sure?')
    	));
    	return $this;
    }
    
    /**
     * Filter für Titel
     * 
     * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
     *
     * @return void
     */
    protected function _filterTitleCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $value = "%$value%";
       	$collection->getSelect()->having(sprintf("`title` like '%s'", $value));
       	//echo $collection->getSelect()->assemble().'<br/>';
    }
    
    /**
     * Filter für Preis
     * 
     * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
     * 
     * @return void
     */
    protected function _filterPriceCondition($collection, $column) {
    	if (!$value = $column->getFilter()->getValue()) {
    		return;
    	}
    	if (is_array($value)) {
    		if (isset($value['from'])) {
    			$from = (float) $value['from'];
    			$collection->getSelect()->having('price >= ?', $from);
    		}
    		if (isset($value['to'])) {
    			$to = (float) $value['to'];
    			$collection->getSelect()->having('price <= ?', $to);
    		}
    	}
    	//echo $collection->getSelect()->assemble().'<br/>';
    }
    
    /**
     * Liefert den Store zurück
     *
     * @return Mage_Core_Model_Store>
     */
    protected function _getStore()
    {
    	$storeId = (int) $this->getRequest()->getParam('store', 0);
    	return Mage::app()->getStore($storeId);
    }
    
    /**
     * Get product that is being edited
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct() {
    	$product = Mage::registry('product');
    	
    	if ($product instanceof Mage_Catalog_Model_Product) {
    		return $product;
    	}
    	
    	$productId  = (int) $this->getRequest()->getParam('id');
    	$product    = Mage::getModel('catalog/product')
    					->setStoreId($this->getRequest()->getParam('store', 0))
    	;
    	
    	$product->setData('_edit_mode', true);
    	if ($productId) {
    		try {
    			$product->load($productId);
    		} catch (Exception $e) {
    			$product->setTypeId(Mage_Catalog_Model_Product_Type::DEFAULT_TYPE);
    			Mage::logException($e);
    		}
    	}
    	
    	Mage::register('product', $product);
    	
    	return $product;
    }
    
    /**
     * Liefert die Grid-URL
     *
     * @return string
     */
    public function getGridUrl() {
    	$url =$this->getUrl('configdownloadable/adminhtml_configdownloadable_product_edit/grid', array('_current'=>true));
    	return $url;
    }

    /**
     * Retrieve Add button HTML
     *
     * @return string
     */
    public function getAddButtonHtml()
    {
        return '';
    }

    /**
     * Return array of links
     *
     * @return array
     * 
     * @deprecated Grid wird nun benutzt
     */
    public function getLinkData()
    {
        $linkArr = array();
        $links = $this->getProduct()->getTypeInstance(true)->getLinks($this->getProduct());
        $priceWebsiteScope = $this->getIsPriceWebsiteScope();
        foreach ($links as $item) {
            $tmpLinkItem = array(
                'link_id' => $item->getId(),
            	'link_file_id' => $item->getLinkFileId(),
                'title' => $item->getTitle(),
                'price' => $this->getCanReadPrice() ? $this->getPriceValue($item->getPrice()) : '',
                'number_of_downloads' => $item->getNumberOfDownloads(),
                'is_shareable' => $item->getIsShareable(),
                'link_url' => $item->getLinkUrl(),
                'link_type' => $item->getLinkType(),
                'sample_file' => $item->getSampleFile(),
                'sample_url' => $item->getSampleUrl(),
                'sample_type' => $item->getSampleType(),
                'sort_order' => $item->getSortOrder(),
            );
            $file = Mage::helper('downloadable/file')->getFilePath(
                Mage_Downloadable_Model_Link::getBasePath(), $item->getLinkFile()
            );

            if ($item->getLinkFile() && !is_file($file)) {
                Mage::helper('core/file_storage_database')->saveFileToFilesystem($file);
            }

            if ($item->getLinkFile() && is_file($file)) {
                $name = '<a href="'
                    . $this->getUrl('*/downloadable_product_edit/link', array(
                        'id' => $item->getId(),
                        '_secure' => true
                    )) . '">' . Mage::helper('downloadable/file')->getFileFromPathFile($item->getLinkFile()) . '</a>';
                $tmpLinkItem['file_save'] = array(
                    array(
                        'file' => $item->getLinkFile(),
                        'name' => $name,
                        'size' => filesize($file),
                        'status' => 'old'
                    ));
            }
            $sampleFile = Mage::helper('downloadable/file')->getFilePath(
                Mage_Downloadable_Model_Link::getBaseSamplePath(), $item->getSampleFile()
            );
            if ($item->getSampleFile() && is_file($sampleFile)) {
                $tmpLinkItem['sample_file_save'] = array(
                    array(
                        'file' => $item->getSampleFile(),
                        'name' => Mage::helper('downloadable/file')->getFileFromPathFile($item->getSampleFile()),
                        'size' => filesize($sampleFile),
                        'status' => 'old'
                    ));
            }
            if ($item->getNumberOfDownloads() == '0') {
                $tmpLinkItem['is_unlimited'] = ' checked="checked"';
            }
            if ($this->getProduct()->getStoreId() && $item->getStoreTitle()) {
                $tmpLinkItem['store_title'] = $item->getStoreTitle();
            }
            if ($this->getProduct()->getStoreId() && $priceWebsiteScope) {
                $tmpLinkItem['website_price'] = $item->getWebsitePrice();
            }
            $linkArr[] = new Varien_Object($tmpLinkItem);
        }
        return $linkArr;
    }
}
