<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Mysql4_Invoice_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Mysql4_Invoice_Collection extends Mage_Sales_Model_Mysql4_Order_Invoice_Item_Collection
{
    /**
     * die order items mit dem höchsten Nettoumsatz (Netto-Preis * Menge)
     */
	protected $_itemsPerOrder = array();
	
 	protected function _initSelect()
    {
      
    	$helper = Mage::helper('ibewi');
    	$this->getSelect()->from(array('main_table' => $this->getMainTable()));    	
      	
     	// sku für den Versand in abhängigkeit von der steuer ermitteln 	
      	$skuset = $helper->getConfigValue('vesand_sku')->asArray();
      	$case = "";
      	foreach ($skuset as $item)
      	{
      		$case .= " WHEN ".$item['value']." then '".$item['label']."' ";
      	}
      	
      	$case .= " END) ";
      	
      	$versandSKU = new Zend_Db_Expr("(select case COALESCE(round(100 * `sales_flat_invoice`.`shipping_tax_amount` / `sales_flat_invoice`.`shipping_amount`),0) $case as sku");    	
      	$suffixIncrementId = new Zend_Db_Expr("order.increment_id as suffixincrementid") ;
        
      	$leistungsAdr = new Zend_Db_Expr("(SELECT IF(order_item.is_virtual = 0,order.shipping_address_id,base_address_id)) AS leistungs_addresse");
      	
      	
      $eav = Mage::getResourceModel('eav/entity_attribute'); 
      
      $bewirtschafter = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')."' as bewirtschafter");
      $konto = new Zend_Db_Expr("'".$helper->getConfigValue('konto1')."' as konto");
      $base_tax_amount = new Zend_Db_Expr("COALESCE(main_table.base_tax_amount,'0.0000') as base_tax_amount_notnull");

      $this->getSelect()
      	->reset(Zend_Db_Select::COLUMNS)
       	->join(array('invoice'=>'sales_flat_invoice'),'invoice.entity_id=main_table.parent_id',
      		array('invoice_increment_id' => 'increment_id','invoice_date' => 'created_at','invoice_update'=> 'updated_at','order_id'))
      	->columns(array('sku','name','qty','price','base_price','row_total',$base_tax_amount,'price_incl_tax','row_total_incl_tax'))
      	->join(array('order'=>'sales_flat_order'),'order.entity_id=invoice.order_id',
      		array('order_increment_id' => 'increment_id','order_date' => 'created_at','customer_id','shipping_address_id','billing_address_id'))
      	->joinleft(array('product'=>'catalog_product_entity'),'main_table.product_id=product.entity_id',array())
	       	->columns('order_item.ibewi_maszeinheit as ibewi_maszeinheit')
      	->joinleft(array('product_haushaltstelle_att'=>'catalog_product_entity_varchar'), 'product_haushaltstelle_att.entity_id=main_table.product_id AND product_haushaltstelle_att.attribute_id='.$eav->getIdByCode('catalog_product', 'haushaltsstelle'), array())
      	->joinleft(array('product_haushaltstelle'=>$this->getTable('paymentbase/haushaltsparameter')), 'product_haushaltstelle.paymentbase_haushaltsparameter_id=product_haushaltstelle_att.value' , array('haushaltstelle'=>'value'))
      	->columns(new Zend_Db_Expr("0 as is_versand"))
      	//->joinleft(array('product_kostentraeger'=>'catalog_product_entity_varchar'), 'product_kostentraeger.entity_id=main_table.product_id AND product_kostentraeger.attribute_id='.$eav->getIdByCode('catalog_product', 'kostentraeger'), array('kostentraeger'=>'value'))
      	
       	->joinleft(array('product_kostenstl'=>'catalog_product_entity_varchar'), 'product_kostenstl.entity_id=main_table.product_id AND product_kostenstl.attribute_id='.$eav->getIdByCode('catalog_product', 'kostenstelle'), array())
       	->joinleft(array('product_kostenstelle'=>'eav_attribute_option_value'), 'product_kostenstelle.option_id=product_kostenstl.value AND product_kostenstelle.store_id=0',array('kostenstelle'=>'value'))
       	
       	
       	->joinleft(array('product_objektnummer_att'=>'catalog_product_entity_varchar'), 'product_objektnummer_att.entity_id=main_table.product_id AND product_objektnummer_att.attribute_id='.$eav->getIdByCode('catalog_product', 'objektnummer'), array())
       	->joinleft(array('product_objektnummer'=>$this->getTable('paymentbase/haushaltsparameter')), 'product_objektnummer.paymentbase_haushaltsparameter_id=product_objektnummer_att.value' , array('objektnummer'=>'value'))
       	 
       	->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id=main_table.order_item_id',array('tax_percent','is_virtual','kostentraeger'))   	
       	->joinleft(array('payment'=>'sales_flat_order_payment'), 'order.entity_id=payment.parent_id', array('kassenzeichen'))  
      	->columns($bewirtschafter)
      	->columns($konto)
      	->columns($suffixIncrementId)
      	->joinleft(array('address'=>'sales_flat_order_address'), "address.address_type= IF (order.is_virtual=0,'shipping','base_address') AND address.parent_id = order.entity_id",array('base_address_id'=>'address.entity_id'))
      	->columns($leistungsAdr)
        ->where('invoice.state != '.Mage_Sales_Model_Order_Invoice::STATE_CANCELED)
      	;
      	
 // die($this->getSelect()->__toString());    	
      	
      	//Versandkosten
        $bewirtschafter = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')."' as bewirtschafter");	
        $hh_versand = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/haushaltsstelle')."' as haushaltsstelle");	
        $obj_versand = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/objektnummer')."' as objektnummer");	
        $tax_percent = new Zend_Db_Expr('COALESCE(round(100 * `sales_flat_invoice`.`shipping_tax_amount` / `sales_flat_invoice`.`shipping_amount`),0.0000) as tax_percent');
        $suffixIncrementId = new Zend_Db_Expr("order.increment_id as suffixincrementid") ;
      	
        $leistungsAdr = new Zend_Db_Expr("(SELECT order.shipping_address_id AS leistungs_addresse, 0 as base_address_id)");
        
      	$sql2 = new Zend_Db_Select($this->_select->getAdapter());
      	$sql2
      	->from('sales_flat_invoice',array('invoice_increment_id' => 'increment_id','invoice_date' => 'created_at','invoice_update'=> 'updated_at','order_id'))
      	->columns($versandSKU)
      	->columns(new Zend_Db_Expr("'Versand' as name"))
      	->columns(new Zend_Db_Expr("1.0000 as qty"))
      	->columns(new Zend_Db_Expr("`sales_flat_invoice`.`shipping_amount` as price"))
      	->columns(new Zend_Db_Expr("`sales_flat_invoice`.`base_shipping_amount` as base_price"))
      	->columns(new Zend_Db_Expr("`sales_flat_invoice`.`shipping_amount` as row_total"))
      	->columns(new Zend_Db_Expr("`sales_flat_invoice`.`shipping_tax_amount` as base_tax_amount"))
      	->columns(new Zend_Db_Expr("`sales_flat_invoice`.`shipping_incl_tax` as price_incl_tax"))
      	->columns(new Zend_Db_Expr("`sales_flat_invoice`.`shipping_incl_tax` as row_total_incl_tax"))
      	->join(array('order'=>'sales_flat_order'),'order.entity_id=sales_flat_invoice.order_id',
      		array('order_increment_id' => 'increment_id','order_date' => 'created_at','customer_id','shipping_address_id','billing_address_id'))
      	->columns(new Zend_Db_Expr("'".$helper->getConfigValue('ibewi_maszeinheit_versand')."' as ibewi_maszeinheit"))
      	->columns($hh_versand)
      	//kennzeichen für Versandposition
      	->columns(new Zend_Db_Expr("1 as is_versand"))
      	
      	->columns(new Zend_Db_Expr("'' as kostenstelle"))
       	->columns($obj_versand)
      	->columns($tax_percent)
      	->columns(new Zend_Db_Expr('1 as is_virtual'))
      	->columns(new Zend_Db_Expr("'' as kostentraeger"))
      	->joinleft(array('payment'=>'sales_flat_order_payment'), 'order.entity_id=payment.parent_id', array('kassenzeichen'))  
       	->columns($bewirtschafter)
      	->columns($konto)
      	->columns($suffixIncrementId)
      	->columns(new Zend_Db_Expr("(SELECT 0) as base_address_id"))
      	->columns(new Zend_Db_Expr("(SELECT order.shipping_address_id) AS leistungs_addresse"))
      	
      	->where('`sales_flat_invoice`.`shipping_amount` > 0')
      	->where('sales_flat_invoice.state != '.Mage_Sales_Model_Order_Invoice::STATE_CANCELED)
        ;

      	$sql1 = $this->getSelect();
      	
      	
      	$sql = new Zend_Db_Select($this->_select->getAdapter());
      	$sql = $sql->union(array($sql1,$sql2),Zend_Db_Select::SQL_UNION_ALL);
      	$this->_select = new Varien_Db_Select($this->_select->getAdapter());
 		$this->_select->from($sql)->order('invoice_increment_id');
      
 		//die($this->getSelect()->__toString());  
        
        
        
        return $this;
    }
	
	protected function _afterLoad()
	{
		//die Produkte nach Nettoumsatz sortieren
		foreach($this->getItems() as $item){
			//nur positionen die nicht Versand und nicht Virtuell sind
			//$item->getIsVersand kommt aus der SQL Union und kennzeichnet die Position des Versandes
			if(($item->getIsVersand() == 0) && ($item->getIsVirtual() == 0)){
				if(isset($this->_itemsPerOrder[$item->getOrderId()]))
				{
					$needle = $this->_itemsPerOrder[$item->getOrderId()];
					if($needle->getRowTotal() < $item->getRowTotal()){
						$this->_itemsPerOrder[$item->getOrderId()] = $item;
					}
				}
				else{
					$this->_itemsPerOrder[$item->getOrderId()] = $item;
				}
			}
		}

		//für die Versandpositionen kostenträger setzten
		foreach($this->getItems() as $item){
			//nur positione die Versand sind
			if($item->getIsVersand() == 1){
				if(isset($this->_itemsPerOrder[$item->getOrderId()])){
					$needle = $this->_itemsPerOrder[$item->getOrderId()];
					$item->setKostentraeger($needle->getKostentraeger());
					$item->setKostenstelle($needle->getKostenstelle());
				}
			}
		}
		
		return parent::_afterLoad();
	}
}