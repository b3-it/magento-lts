<?php

class Egovs_Ready_Model_Setup extends Mage_Catalog_Model_Resource_Setup
{
	public function getTemplateContent($filename)
	{
		$file = dirname(__FILE__) .DS. ".." .DS ."data" .DS . "cms" . DS. $filename;
		$file = realpath($file);
		
		if(file_exists($file))
		{
			return $this->file_get_contents_utf8($file);
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
			$cms->setData($data)->save();
		}
	}
	
	private function file_get_contents_utf8($fn) {
		$content = file_get_contents($fn);
		return mb_convert_encoding($content, 'UTF-8',
				mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
	}
	
}