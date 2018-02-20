<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Copy_Entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy extends Bkg_License_Model_Textprocess
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/copy');
    }
    
    protected function _saveRelated($collection)
    {
    	if($collection != null){
    		foreach($collection as $item){
    			$item->setCopyId($this->getId());
    			$item->save();
    		}
    	}
    }
    
    /**
     *
     * @param unknown $resourceName
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _getRelated($resourceName)
    {
    	$collection = Mage::getModel($resourceName)->getCollection();
    	$collection->getSelect()->where('copy_id=?',intval($this->getId()));
    	 
    	return $collection->getItems();
    }
    
    
    public function processTemplate()
    {
    	$this->setContent($this->_replaceVariables($this->getTemplate()));
    	return $this;
    }
		
	public function createPdf($content = null)
	{
		if($content == null)
		{
			$content = $this->getContent();
		}
		
		$pdf = Mage::getModel('bkg_license/copy_pdf');
		//$pdf->preparePdf();
		$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_PREVIEW;
		$pdf->getPdf(array($this))->render();
		
		
	}
	
	public function createPdfFile()
	{
		$file = Mage::getModel('bkg_license/copy_file');
		$file->setCopyId($this->getId());
		$pdf = Mage::getModel('bkg_license/copy_pdf');
		//$pdf->preparePdf();
		$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_STANDARD;
		$path = Mage::helper('bkg_license')->getLicenseFilePath($this->getId()).DS.$file->getHashFilename();
		$pdf->getPdf(array($this))->save($path);
		
		$file->setOrigFilename(Mage::helper('bkg_license')->__('License').'_' .Mage::getSingleton('core/date')->date('Y-m-d__H_i_s').'.pdf');
		$file->save();
	}
	
    
}
