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
            $journal->setConfig($this->getConfig($storeId));
            $journal->setImprint($this->getImprint($storeId));

			$extKzA = array();
			$extKzS = 0.0;
			
			$intKzA = array();
			$intKzS = 0.0;
			
			foreach($items as $item){
				if(empty($item->getExternesKassenzeichen())){
					$item->setExternesKassenzeichenText(Mage::helper('gka_barkasse')->__('No'));
						$intKzA[] = $item;
						$intKzS += $item->getBookingAmount();
				}
				else{
					$item->setExternesKassenzeichenText(Mage::helper('gka_barkasse')->__('Yes'));
					$extKzA[] = $item;
					$extKzS += $item->getBookingAmount();
				}
				$item->setStatus(Mage::helper('gka_barkasse')->__($item->getStatus()));
			}
			
			if(count($extKzA) > 0){
				$extKzA[] = new Varien_Object(array('booking_amount'=>$extKzS));
			}else{
				$extKzA = null;
			}
			if(count($intKzA) > 0){
				$intKzA[] = new Varien_Object(array('booking_amount'=>$intKzS));
			}else{
				$intKzA = null;
			}
			
			
			$journal->setInternalItems($intKzA);
			$journal->setExternalItems($extKzA);
			
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
