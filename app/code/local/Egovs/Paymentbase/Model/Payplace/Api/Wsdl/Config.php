<?php
class Egovs_Paymentbase_Model_Payplace_Api_Wsdl_Config extends Mage_Api_Model_Wsdl_Config
{
	public function init()
	{
		$this->setCacheChecksum(null);
		$saveCache = true;
	
		if (Mage::app()->useCache('config')) {
			$loaded = $this->loadCache();
			if ($loaded) {
				return $this;
			}
		}
	
		$mergeWsdl = new Egovs_Paymentbase_Model_Payplace_Api_Wsdl_Config_Base();
		$mergeWsdl->setHandler($this->getHandler());
	
		if(Mage::helper('api/data')->isComplianceWSI()){
			/**
			 * Exclude Mage_Api wsdl xml file because it used for previous version
			 * of API wsdl declaration
			 */
			$mergeWsdl->addLoadedFile(Mage::getConfig()->getModuleDir('etc', "Egovs_Paymentbase").DS.'payplace.wsi.xml');
	
			$baseWsdlFile = Mage::getConfig()->getModuleDir('etc', "Egovs_Paymentbase").DS.'payplace.wsi.xml';
			$this->loadFile($baseWsdlFile);
			Mage::getConfig()->loadModulesConfiguration('payplace.wsi.xml', $this, $mergeWsdl);
		} else {
			/**
			 * Exclude Mage_Api wsdl xml file because it used for previous version
			 * of API wsdl declaration
			 */
			$mergeWsdl->addLoadedFile(Mage::getConfig()->getModuleDir('etc', "Egovs_Paymentbase").DS.'payplace.wsdl.xml');
	
			$baseWsdlFile = Mage::getConfig()->getModuleDir('etc', "Egovs_Paymentbase").DS.'payplace.wsdl.xml';
			$this->loadFile($baseWsdlFile);
			Mage::getConfig()->loadModulesConfiguration('payplace.wsdl.xml', $this, $mergeWsdl);
		}
	
		if (Mage::app()->useCache('config')) {
			$this->saveCache(array('config'));
		}
	
		return $this;
	}
}