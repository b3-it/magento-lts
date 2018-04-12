<?php
class Bkg_VirtualAccess_Model_Resource_Setup extends Mage_Catalog_Model_Resource_Setup
{
	public function createEmail($emailData) {
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
	
	public function templateExists($code) {
		$model = Mage::getModel('core/email_template')->loadByCode($code);
		return !$model->isEmpty();
	}
}