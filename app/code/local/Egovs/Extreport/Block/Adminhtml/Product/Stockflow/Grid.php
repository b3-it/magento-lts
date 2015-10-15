<?php
/**
 * Adminhtml Report: Verlauf der Bestandsmengen Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Product_Stockflow_Grid extends Egovs_Extreport_Block_Adminhtml_AbstractReportGrid
{
	protected $_baseActionName = 'stockflow';
	
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
        $this->setId('gridStockflowProduct');
        $this->setVarNameFilter('stockflow_filter');
        $this->addExportType('*/*/exportStockflowCsv', 'CSV');
        $this->addExportType('*/*/exportStockflowExcel', 'XML (Excel)');
        
        $this->setTemplate('egovs/extreport/grid.phtml');
        
        $this->setSubReportSize(0);	//nicht beschränkt!
    }

    /**
     * Initialisiert die Collection
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Stockflow_Grid
     */
    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $this->getCollection()->initReport('extreport/product_stockflow_collection');
        
    	return $this;
    }
    /**
     * Initialisiert die Spalten
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Stockflow_Grid
     */
    protected function _prepareColumns()
    {
    	$this->addColumn('entity_id', array(
            'header'    =>Mage::helper('reports')->__('ID'),
            'index'     =>'entity_id'
        ));
        
    	$this->addColumn('name', array(
            'header'    =>Mage::helper('reports')->__('Product Name'),
            'index'     =>'name'
        ));
		
        $this->addColumn('qty_inward', array(
            'header'    =>Mage::helper('extreport')->__('Inwards'),
            'width'     =>'120px',
            'align'     =>'right',
            'index'     =>'qty_inward',
            'total'     =>'sum',
            'type'      =>'number'
        ));
        
        $this->addColumn('qty_outward', array(
            'header'    =>Mage::helper('extreport')->__('Outwards'),
            'width'     =>'120px',
            'align'     =>'right',
            'index'     =>'qty_outward',
            'total'     =>'sum',
            'type'      =>'number'
        ));

        $this->addColumn('diff', array(
            'header'    =>Mage::helper('extreport')->__('Difference'),
            'width'     =>'120px',
            'align'     =>'right',
            'index'     =>'diff',
            'total'     =>'sum',
            'type'      =>'number'
        ));	

       return parent::_prepareColumns();
    }
}