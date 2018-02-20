<?php
/**
 * 
 *  PDF von Lizenztexten erzeugen
 *  @category Bkg
 *  @package  Bkg_License_Model_Copy_Pdf
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy_Pdf extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
	public function preparePdf($license = array())
	{
			$license = array_shift($license);
			$this->Name = Mage::helper('bkg_license')->__('License').'_' .Mage::getSingleton('core/date')->date('Y-m-d__H_i_s').'.pdf';		

			$license->setTemplateId($license->getPdfTemplateId());
			
			
			$this->LoadTemplate($license);
			
			$this->_Pdf->addPage();
			
			$this->RenderAddress($license,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS]);
			$this->RenderTable($license, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY]);
			$this->_Pdf->lastPage();
			$this->_Pdf->ResetPagesSinceStart();
			return $this;
	}
}
