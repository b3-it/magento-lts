<?php
/**
 * 
 *  Setup Module zur Vereinfachung des Aufrufs bei der Intallation
 *  @category Gka_Base
 *  @package  Gka_Base
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Base_Model_Setup extends Mage_Eav_Model_Entity_Setup
{
	public function CreateTemplate($data)
	{
		$template = Mage::getModel('pdftemplate/template');		
		$template->setData($data['general']);
		$template->save();
	
		$model = Mage::getModel('pdftemplate/section');		
		$model->setData($data['header']);
		$model->setPdftemplateTemplateId($template->getId());
		$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_HEADER);
		$model->save();
		
		$model = Mage::getModel('pdftemplate/section');		
		$model->setData($data['address']);
		$model->setPdftemplateTemplateId($template->getId());
		$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS);
		$model->save();
		
		$model = Mage::getModel('pdftemplate/section');		
		$model->setData($data['body']);
		$model->setPdftemplateTemplateId($template->getId());
		$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY);
		$model->save();
		
		$model = Mage::getModel('pdftemplate/section');		
		$model->setData($data['footer']);
		$model->setPdftemplateTemplateId($template->getId());
		$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_FOOTER);
		$model->save();
		
		$model = Mage::getModel('pdftemplate/section');		
		$model->setData($data['marginal']);
		$model->setPdftemplateTemplateId($template->getId());
		$model->setSectiontype(Egovs_Pdftemplate_Model_Sectiontype::TYPE_MARGINAL);
		$model->save();
	}


	public function createBlock($data)
    {
        $data['created_time']= now();
        $data['update_time']=  now();
        $template = Mage::getModel('pdftemplate/blocks');
        $template->setData($data);
        $template->save();
    }
} 