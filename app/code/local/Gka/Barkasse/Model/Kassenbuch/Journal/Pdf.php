<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Model_Kassenbuch_Journal_Pdf
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Model_Kassenbuch_Journal_Pdf extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
	public function preparePdf($journal = array())
	{
			$journal = array_shift($journal);
			$this->Name = Mage::helper('gka_barkasse')->__('Kassenabschlussprotokoll').'_' .Mage::getSingleton('core/date')->date('d_m_Y__H_i_s').'.pdf';		

			$storeId = $journal->getCashbox()->getStoreId();
			
			$template = Mage::getStoreConfig('payment/epaybl_cashpayment/pdf_report',$storeId);
			
			$items = $journal->getItemsCollection()->getItems();
			
			
			foreach($items as $item){
				if(empty($item->getExternesKassenzeichen())){
					$item->setExternesKassenzeichenText(Mage::helper('gka_barkasse')->__('No'));
				}
				else{
					$item->setExternesKassenzeichenText(Mage::helper('gka_barkasse')->__('Yes'));
				}
			}
			
			
			
			$journal->setItems($items);
			
			$journal->setTemplateId($template);
			
			
			$this->LoadTemplate($journal);
			
			$this->_Pdf->addPage();
			
			$this->RenderAddress($journal,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS]);
			$this->RenderTable($journal, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY]);
			$this->_Pdf->lastPage();
			$this->_Pdf->ResetPagesSinceStart();
			return $this;
	}
}
