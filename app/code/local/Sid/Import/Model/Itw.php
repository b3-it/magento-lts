<?php
class  Sid_Import_Model_Itw extends B3it_XmlBind_ProductBuilder_Abstract
{
	protected $_webSiteId = 1;
	
	protected $category_id = 3;

	protected function _getEntityDefaultRow()
	{
		$res = array();
		$res['store_group'] = 1;
		return $res;
	}
	
	protected function _getAttributeDefaultRow()
	{
		$res = array();
		$res['status'] = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
		$res['visibility'] = Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH;
		$res['framecontract_los'] = 2;
		$res['groupscatalog2_groups'] = -1;
		$res['framecontract_qty'] = 0;

		return $res;
	}
	
	protected function _getTaxClassId($taxRate)
	{
		return 4;
	}
	
}
