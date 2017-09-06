<?php

/**
 * 
 *  Logging auf Module Ebene muss Parent von Varien_Object sein
 *  aufruf über $this->setLog('message');
 *  aufruf über $this->setLogException(Exception);
 *  file: modules.log
 *  @category Egovs
 *  @package  Egovs_Object
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/* Template für system.xml
       <dev>
			<groups>
				<modulelog>
					<fields>
						<egovs_pdftemplate>
							<label>PdfTemplate</label>
							<frontend_type>select</frontend_type>
							<source_model>adminhtml/system_config_source_yesno</source_model>
							<show_in_default>1</show_in_default>
							<show_in_website>1</show_in_website>
							<show_in_store>1</show_in_store>
						</egovs_pdftemplate>
					</fields>
				</modulelog>
			</groups>
		</dev>
 */

class Egovs_Object 
{
    /**
     * Object isLogEnabled
     *
     * @var boolean
     */
    private $_isLogEnabled = null;

    /**
     * Object ModuleName
     *
     * @var string
     */
    private $_ModuleName = null;
	
	
    /**
     * Write Memory-message to LOG-File
     *
     */
    protected function setLog($msg)
	{
		if($this->isLogEnabled())
		{
			$mem = memory_get_usage() /1024 / 1024;
			$memstr = number_format($mem,2)." MB";
			$time = date('d.m.Y H:i:s');
			$msg = $time."|". $memstr ."|". $this->getModuleName().":: ".$msg;
			file_put_contents(Mage::getBaseDir('log').DS. 'module.log',$msg."\n",FILE_APPEND);
		}
	}
	
	/**
	 * Error-Handling
	 *
	 */
	protected function setLogException(Exception $ex)
	{
		$this->setLog($ex->getMessage());
	}
	
	/**
	 * Check if Logging is Enabled (StoreView)
	 *
     * @return bool
	 */
	private function isLogEnabled()
	{
		if($this->_isLogEnabled === null)
		{
			$config = Mage::getStoreConfig('dev/modulelog/'.$this->getModuleName());
			
			if($config === '1'){
				$this->_isLogEnabled = true;
			} else {
				$this->_isLogEnabled = false;
			}
		}
		
		return $this->_isLogEnabled;
	}
	
	
	/**
	 * Return the Name of the current Module
	 *
	 * @return string
	 */
	private function getModuleName()
	{
		if($this->_ModuleName == null)
		{
			$this->_ModuleName = get_class($this);
			$tmp = explode('_', $this->_ModuleName);
			if(is_array($tmp) && isset($tmp[1]))
			{
				$this->_ModuleName = strtolower($tmp[0]);
				$this->_ModuleName .= "_" . strtolower($tmp[1]);
			}
			
		}
		return $this->_ModuleName;
	}
	
	
	/**
	 * Check if Field ist set in Data-Array
	 *
	 * @return bool
	 */
	public function isFieldEquals($field, $compareTo)
	{
		$field = $this->getData($field);
		return boolval($field == $compareTo);
	}
}