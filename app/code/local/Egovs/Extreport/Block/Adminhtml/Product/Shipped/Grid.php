<?php
/**
 * Adminhtml Report: Versendete Waren Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Product_Shipped_Grid extends Egovs_Extreport_Block_Adminhtml_AbstractReportGrid
{
    /**
     * Sub-Report size
     *
     * @var int
     */
    protected $_subReportSize = 0;
    
    protected $_baseActionName = 'shipped';

    /**
	 * Initialisiert das Grid
	 *
	 * Setzt eigenes Template
	 * 
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
        $this->setId('gridProductsShipped');
        $this->setVarNameFilter('shipped_filter');
        
        $this->setTemplate('egovs/extreport/grid.phtml');
    }

    /**
     * Initialisiert die Collection
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Shipped_Grid
     */
    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $this->getCollection()
            ->initReport('extreport/product_shipped_collection');
        return $this;
    }

    /**
     * Initialisiert die Spalten
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Shipped_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('name', array(
            'header'    =>Mage::helper('reports')->__('Product Name'),
            'index'     =>'name'
        ));

        $this->addColumn('shipped_qty', array(
            'header'    =>Mage::helper('extreport')->__('Quantity Shipped'),
            'width'     =>'120px',
            'align'     =>'right',
            'index'     =>'shipped_qty',
            'total'     =>'sum',
            'type'      =>'number'
        ));

        $this->addExportType('*/*/exportShippedCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportSoldExcel', Mage::helper('extreport')->__('XML (Excel)'));

        return parent::_prepareColumns();
    }
}
