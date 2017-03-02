<?php
/**
 * Installer
 *
 * @category		Egovs
 * @package			Egovs_Ready
 * @name			Egovs_Ready_Model_Setup
 * @author			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright		Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license			http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @version			0.1.0.0
 * @since			0.1.0.0
 *
 */
class Egovs_Ready_Model_Setup extends Mage_Catalog_Model_Resource_Setup
{
	public function getTemplateContent($filename)
	{
		$file = dirname(__FILE__) .DS. ".." .DS ."data" .DS . "cms" . DS. $filename;
		$file = realpath($file);
		
		if (file_exists($file)) {
			return $this->__fileGetContentsUtf8($file);
		}
		return "";
		 
	}
	
	
	public function saveCmsPage($data)
	{
		/* @var $cms Mage_Cms_Model_Cms */
		$cms = Mage::getModel('cms/page')->load($data['identifier']);
		
		
		if (!(int)$cms->getId()) {
			// create
			$cms->setData($data)->save();
		} else {
			// update
			$data['stores'] = $cms->getStoreId();	
			$data['page_id'] = $cms->getId();
			$data['content'] = $cms->getContent();
			$cms->setData($data)->save();
		}
	}
	
	public function saveCmsBlock($data)
	{
		/* @var $cms Mage_Cms_Model_Cms */
		$cms = Mage::getModel('cms/block')->load($data['identifier']);
		
		
		if (!(int)$cms->getId()) {
			// create
			$cms->setData($data)->save();
		} else {
			// update;
			$data['stores'] = $cms->getStoreId();
			$data['block_id'] = $cms->getId();
			$data['content'] = $cms->getContent();
			$cms->setData($data)->save();
		}
	}
	
	/**
	 * Agreement anlegen
	 *
	 * @param array $agreementData Agreement Daten
	 *
	 * @return void
	 */
	public function createAgreement($agreementData)
	{
		$agreementData['is_active'] = '1';
		$agreementData['is_html'] = '1';
		$agreementData['stores'] = array('0');
	
		$agreement = Mage::getModel('checkout/agreement');
		$agreement->setData($agreementData)
				->save()
		;
	}
	
	private function __fileGetContentsUtf8($fn) {
		$content = file_get_contents($fn);
		return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
	}
	
}