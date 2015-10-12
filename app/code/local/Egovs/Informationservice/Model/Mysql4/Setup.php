<?php
class Egovs_Informationservice_Model_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{
	function createEmail($emailData) {
		$model = Mage::getModel('core/email_template');
		$template = $model->setTemplateSubject($emailData['template_subject'])
		->setTemplateCode($emailData['template_code'])
		->setTemplateText($emailData['text'])
		->setTemplateType($emailData['template_type'])
		->setModifiedAt(Mage::getSingleton('core/date')->gmtDate())
		->save()
		;
	
		$this->setConfigData($emailData['config_data_path'], $template->getId());
	
		return $this;
	}
}