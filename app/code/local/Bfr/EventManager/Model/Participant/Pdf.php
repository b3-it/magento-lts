<?php
/**
 * Bfr EventManager Pdf
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Participant_Pdf
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Participant_Pdf extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
    public function preparePdf($participant = array())
    {
        $participant = array_shift($participant);
        $this->Name = Mage::helper('eventmanager')->__('ParticipationCertificate').'_' .Mage::getSingleton('core/date')->date('Y-m-d__H_i_s').'.pdf';

        $participant->setTemplateId($participant->getEvent()->getPdftemplateId());

        $this->LoadTemplate($participant);

        $this->_Pdf->addPage();

        $this->RenderAddress($participant,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS]);
        $this->RenderTable($participant, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY]);
        $this->_Pdf->lastPage();
        $this->_Pdf->ResetPagesSinceStart();
        return $this;
    }


}
