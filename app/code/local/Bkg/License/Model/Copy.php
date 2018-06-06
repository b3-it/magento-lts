<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Copy_Entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getType()
 *  @method setType(int $value)
 *  @method int getReuse()
 *  @method setReuse(int $value)
 *  @method string getIdent()
 *  @method setIdent(string $value)
 *  @method string getName()
 *  @method setName(string $value)
 *  @method  getDateFrom()
 *  @method setDateFrom( $value)
 *  @method  getDateTo()
 *  @method setDateTo( $value)
 *  @method int getActive()
 *  @method setActive(int $value)
 *  @method int getConsternationCheck()
 *  @method setConsternationCheck(int $value)
 *  @method string getTemplate()
 *  @method setTemplate(string $value)
 *  @method string getContent()
 *  @method setContent(string $value)
 *  @method int getCustomerId()
 *  @method setCustomerId(int $value)
 *  @method int getOrgunitId()
 *  @method setOrgunitId(int $value)
 *  @method int getIsOrgunit()
 *  @method setIsOrgunit(int $value)
 *  @method int getPdfTemplateId()
 *  @method setPdfTemplateId(int $value)
 */
class Bkg_License_Model_Copy extends Bkg_License_Model_Textprocess
{
	
	protected $_period = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/copy');
    }

    public function setPeriod($period)
    {
    	$this->_period = $period;
    }
    
    
    public function getPeriod()
    {
    	if($this->_period == null)
    	{
    		
    		$this->_period = Mage::getModel('bkg_license/copy_period');
    		if($this->getPeriodId())
    		{
    			$this->_period->load($this->getPeriodId());
    		}
    	}
    	return $this->_period;
    }
    
    protected function _saveRelated($collection)
    {
    	if($collection != null){
    		foreach($collection as $item){
    			$item->setCopyId($this->getId());
    			$item->save();
    		}
    	}
    }


    protected function _beforeSave() {
        parent::_beforeSave();

        if($this->_period != null){
            $this->_period->save();
            $this->setPeriodId($this->_period->getId());
        }
    }



    /**
     *
     * @param string $resourceName
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _getRelated($resourceName)
    {
    	$collection = Mage::getModel($resourceName)->getCollection();
    	$collection->getSelect()->where('copy_id=?',intval($this->getId()));

    	return $collection->getItems();
    }


    public function processTemplate()
    {
    	$this->setContent($this->_replaceVariables($this->getTemplate()));
    	return $this;
    }



	public function previewPdf($content = null)
	{
		if($content != null)
		{
			 $this->setContent($content);
		}

		$pdf = Mage::getModel('bkg_license/copy_pdf');
		//$pdf->preparePdf();
		$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_STANDARD;
		return $pdf->getPdf(array($this))->render();

	}

	public function createPdfFile()
	{
		$file = Mage::getModel('bkg_license/copy_file');
		$file->setCopyId($this->getId());
		$pdf = Mage::getModel('bkg_license/copy_pdf');
		//$pdf->preparePdf();
		$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_STANDARD;
		$path = Mage::helper('bkg_license')->getLicenseFilePath($this->getId()).DS.$file->getHashFilename();
		$pdf->getPdf(array($this))->save($path);

		$file->setOrigFilename(Mage::helper('bkg_license')->__('License').'_' .Mage::getSingleton('core/date')->date('Y-m-d__H_i_s').'.pdf');
		$file->save();
		return $file;
	}

    /**
     * ermittelt die Addresen der Lizenz
     */
	public function getAddresses()
	{
		if($this->getIsOrgunit())
		{
			$collection = Mage::getModel('bkg_orgunit/address')->getCollection();
			$collection->getSelect()->where('unit_id=?',intval($this->getOrgunitId()));
			return $collection->getItems();
		}else{
			$collection = Mage::getResourceModel('customer/address_collection');
			$collection->addAttributeToFilter('parent_id', intval($this->getCustomerId()));
			$collection->addAttributeToSelect('*');

			return $collection->getItems();
		}
	}

	public function getAddressRelations()
	{
		$collection = Mage::getModel('bkg_license/copy_address')->getCollection();
        $collection->addCopyIdFilter($this->getId());
        return $collection->getItems();
	}
	
	public function getStatusText()
	{
		$opt = Bkg_License_Model_Copy_Status::getOptionArray();
		
		return $opt[$this->getStatus()];
	}
	
	
	/**
	 * Lizenzen finden
	 * @see Bkg_License_Model_Abstract::getLicense()
	 */
	public function getLicense($customer,$product,$toll, $online_only = true, $find_all = false)
	{
		
		$orgunits = Mage::helper('bkg_orgunit')->getOrganisationByCustomer($customer);
		if(count($orgunits)== 0){
			$orgunits[] = '0';
		}
		$orgunits = implode(',', $orgunits);
		$sql = array();
		$sql[] = "(customer_id={$customer->getId()} AND is_orgunit=0) OR";
		$sql[] = "(orgunit_id IN ({$orgunits}) AND is_orgunit=1)";
		
		$sql = implode(' ', $sql);
		$customerExpr = new Zend_Db_Expr("({$sql})");
		
		$collection = $this->getCollection();
		$date = date('Y-m-d');
		$collection->getSelect()
		->join(array('product'=>$collection->getTable('bkg_license/copy_product')),'product.copy_id = main_table.id',array())
		->join(array('toll'=>$collection->getTable('bkg_license/copy_toll')),'toll.copy_id = main_table.id',array())
		->where('product.product_id=?',intval($product->getId()))
		->where($customerExpr)
		->where('toll.useoption_id=?',intval($toll->getUseoptionId()))
		->where('active=1')
		->where('date_from <=?',$date)
		->where(new Zend_Db_Expr("((date_to IS NULL) OR (date_to >='{$date}  00:00:00'))"))
		;
		if($online_only){
			$collection->getSelect()->where('type=?',Bkg_License_Model_Type::TYPE_ONLINE);
		}
		
		//die($collection->getSelect()->__toString());
		
		if($find_all){
			return $collection;
		}
		
		
		//der erste Treffer gewinnt
		foreach($collection as $item)
		{
			return $item;
		}
		 
		return null;
	}
}
