<?php
/**
 * Sid_ExportOrder_Model_Format_Opentrans
 *
 * Erzeugen eines XML Streams für OpenTrans 2.1
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Model_Format_Opentrans
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "PRODUCT_FEATURES";
	
	
	/* @var $feature Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature */
public $feature = null;
/* @var $reference_feature_system_name Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureSystemName */
public $reference_feature_system_name = null;
/* @var $reference_feature_group_id Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureGroupId */
public $reference_feature_group_id = null;
/* @var $reference_feature_group_name Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureGroupName */
public $reference_feature_group_name = null;
/* @var $reference_feature_group_id2 Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureGroupId2 */
public $reference_feature_group_id2 = null;
/* @var $group_product_order Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_GroupProductOrder */
public $group_product_order = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->feature = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_Feature($node,$this->_xml);
$this->reference_feature_system_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureSystemName($node,$this->_xml);
$this->reference_feature_group_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureGroupId($node,$this->_xml);
$this->reference_feature_group_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureGroupName($node,$this->_xml);
$this->reference_feature_group_id2 = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_ReferenceFeatureGroupId2($node,$this->_xml);
$this->group_product_order = new Sid_ExportOrder_Model_Format_Opentrans_OrderItemList_OrderItem_ProductFeatures_GroupProductOrder($node,$this->_xml);
	}
	
	
	
    
}
