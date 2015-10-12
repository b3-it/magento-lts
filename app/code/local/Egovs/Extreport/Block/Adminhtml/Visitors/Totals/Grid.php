<?php

/**
 * Adminhtml-Besucher-Grid-Block
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Visitors_Totals_Grid extends Egovs_Extreport_Block_Adminhtml_AbstractReportGrid
{
	protected $_baseActionName = 'totals';
	/**
	 * Initialisiert das Grid
	 *
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
       
        $this->setId('gridTotalVisitors');
        $this->setVarNameFilter('visitors_filter');
        $this->setSubReportSize(0);	//nicht beschränkt!
    }

    /**
     * Bereitet die Collection vor
     *
     * @return Egovs_Extreport_Block_Adminhtml_Visitors_Totals_Grid
     */
    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $this->getCollection()->initReport('extreport/visitors_totals_collection');
        
        return $this;
    }

    /**
     * Initialisiert die Spalten
     *
     * @return Egovs_Extreport_Block_Adminhtml_Visitors_Totals_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('name', array(
            'header'    => Mage::helper('extreport')->__('Number of Visitors'),
            'sortable'  => true,
            'index'     => 'visitors',
        	'type'      => 'number'
        ));

        $this->addColumn('totalsec', array(
            'header'    => $this->__('Time Total[min]'),
            'width'     => '100px',
            'sortable'  => false,
            'index'     => 'totalsec',
            'total'     => 'sum',
            'type'      => 'number'
        ));

       $this->addColumn('meansec', array(
            'header'    => $this->__('Mean Time[min]'),
            'width'     => '100px',
            'sortable'  => false,
            'index'     => 'meansec',
            'total'     => 'sum',
            'type'      => 'number'
        ));
       
        $this->addExportType('*/*/exportTotalsCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportTotalsExcel', Mage::helper('reports')->__('Excel'));

        return parent::_prepareColumns();
    }
}