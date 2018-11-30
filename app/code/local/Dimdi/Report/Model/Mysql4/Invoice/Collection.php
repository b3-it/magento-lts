<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Model_Mysql4_Invoice_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Model_Mysql4_Invoice_Collection extends Mage_Sales_Model_Mysql4_Order_Invoice_Item_Collection
{
    
 	protected function _initSelect()
    {
      
    	$helper = Mage::helper('dimdireport');
    	$this->getSelect()->from(array('main_table' => $this->getMainTable()));    	
      	

      	
      	$versandSKU = new Zend_Db_Expr("'versand' as sku");    	
      	$versandGutschriftSKU = new Zend_Db_Expr("'versand' as sku");  
        
      	$company = new Zend_Db_Expr("trim(concat(COALESCE(company,''),' ',COALESCE(company2,''), ' ',COALESCE(company3,''))) ");
      	$name = new Zend_Db_Expr("trim(concat(COALESCE(firstname, ''),' ',COALESCE(lastname,'')))");
      	$address = new Zend_Db_Expr("trim(concat(COALESCE(street,''),', ',COALESCE(postcode,''), ' ',COALESCE(city,''))) ");
      	$versand = new Zend_Db_Expr("'versand' as name");    
      $eav = Mage::getResourceModel('eav/entity_attribute'); 
      
 
      $bewirtschafter = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')."' as bewirtschafter");
      $konto = new Zend_Db_Expr("'Rechnung' as konto");
      $base_tax_amount = new Zend_Db_Expr("COALESCE(main_table.base_tax_amount,'0.0000') as base_tax_amount_notnull");
      //$taxrate = new Zend_Db_Expr("53100 as tax_rate");
      $this->getSelect()
      	->reset(Zend_Db_Select::COLUMNS)
       	->join(array('invoice'=>'sales_flat_invoice'),'invoice.entity_id=main_table.parent_id',
      		array('invoice_increment_id' => 'increment_id','invoice_date' => 'created_at','invoice_update'=> 'updated_at'))
      	->columns(array('sku','name','qty','price','base_price','row_total',$base_tax_amount,'price_incl_tax','row_total_incl_tax'))
      	->join(array('order'=>'sales_flat_order'),'order.entity_id=invoice.order_id',
      		array('order_increment_id' => 'increment_id','order_date' => 'created_at','customer_id','shipping_address_id','billing_address_id'))
      	->joinleft(array('product'=>'catalog_product_entity'),'main_table.product_id=product.entity_id',array('type_id'))
      	->joinleft(array('product_haushaltstelle_att'=>'catalog_product_entity_varchar'), 'product_haushaltstelle_att.entity_id=main_table.product_id AND product_haushaltstelle_att.attribute_id='.$eav->getIdByCode('catalog_product', 'haushaltsstelle'), array())
      	->joinleft(array('product_haushaltstelle'=>$this->getTable('paymentbase/haushaltsparameter')), 'product_haushaltstelle.paymentbase_haushaltsparameter_id=product_haushaltstelle_att.value' , array('haushaltstelle'=>'value'))
       
       	->joinleft(array('product_kostenstl'=>'catalog_product_entity_varchar'), 'product_kostenstl.entity_id=main_table.product_id AND product_kostenstl.attribute_id='.$eav->getIdByCode('catalog_product', 'kostenstelle'), array())
       	->joinleft(array('product_kostenstelle'=>'eav_attribute_option_value'), 'product_kostenstelle.option_id=product_kostenstl.value AND product_kostenstelle.store_id=0',array('kostenstelle'=>'value'))
       	->joinleft(array('product_objektnummer_att'=>'catalog_product_entity_varchar'), 'product_objektnummer_att.entity_id=main_table.product_id AND product_objektnummer_att.attribute_id='.$eav->getIdByCode('catalog_product', 'objektnummer'), array())
       	->joinleft(array('product_objektnummer'=>$this->getTable('paymentbase/haushaltsparameter')), 'product_objektnummer.paymentbase_haushaltsparameter_id=product_objektnummer_att.value' , array('objektnummer'=>'value'))
       	
       	->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id=main_table.order_item_id','tax_percent')   	
       	->joinleft(array('payment'=>'sales_flat_order_payment'), 'order.entity_id=payment.parent_id', array('kassenzeichen','method'))  
      	->columns($bewirtschafter)
      	->columns($konto)
      	->join(array('address'=>'sales_flat_order_address'),"address.parent_id=order.entity_id AND address.address_type ='billing'",array('fullcompany'=>$company,'fullname'=>$name,'address'=>$address,'country_id'))
      	;
      	
  	//die($this->getSelect()->__toString());    	
      	
      	//Versandkosten
        $bewirtschafter = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')."' as bewirtschafter");	
        $hh_versand = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/haushaltsstelle')."' as haushaltsstelle");	
        $obj_versand = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/objektnummer')."' as objektnummer");	
        $tax_percent = new Zend_Db_Expr('COALESCE(round(100 * `sales_flat_invoice`.`shipping_tax_amount` / `sales_flat_invoice`.`shipping_amount`),0.0000) as tax_percent');

      	
      	$sql2 = new Zend_Db_Select($this->_select->getAdapter());
      	$sql2
      	->from('sales_flat_invoice',array('invoice_increment_id' => 'increment_id','invoice_date' => 'created_at','invoice_update'=> 'updated_at'))
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
      	->columns($versand)
      	->columns($hh_versand)
      	->columns($versand)
      	->columns($obj_versand)
      	->columns($tax_percent)
      	->joinleft(array('payment'=>'sales_flat_order_payment'), 'order.entity_id=payment.parent_id', array('kassenzeichen','method'))  
       	->columns($bewirtschafter)
      	->columns($konto)
      	->join(array('address'=>'sales_flat_order_address'),"address.parent_id=order.entity_id AND address.address_type ='billing'",array('fullcompany'=>$company,'fullname'=>$name,'address'=>$address,'country_id'))
      	->where('`sales_flat_invoice`.`shipping_amount` > 0');

      	//die($sql2->__toString());
      	
      	//Gutschrift
      	$bewirtschafter = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')."' as bewirtschafter");	
      	$konto = new Zend_Db_Expr("'Gutschrift' as konto");
      	$collection3 = Mage::getModel('sales/order_creditmemo_item')->getCollection();
      	$collection3->getSelect()
      	->reset(Zend_Db_Select::COLUMNS)
      	->join(array('invoice'=>'sales_flat_creditmemo'),'invoice.entity_id=main_table.parent_id',
      		array('invoice_increment_id' => 'increment_id','invoice_date' => 'created_at','invoice_update'=> 'updated_at'))
      	->columns(array('sku','name','qty','price','base_price','row_total',$base_tax_amount,'price_incl_tax','row_total_incl_tax'))
      	->join(array('order'=>'sales_flat_order'),'order.entity_id=invoice.order_id',
      		array('order_increment_id' => 'increment_id','order_date' => 'created_at','customer_id','shipping_address_id','billing_address_id'))
      	->joinleft(array('product'=>'catalog_product_entity'),'main_table.product_id=product.entity_id',array('type_id'))
      	->joinleft(array('product_haushaltstelle_att'=>'catalog_product_entity_varchar'), 'product_haushaltstelle_att.entity_id=main_table.product_id AND product_haushaltstelle_att.attribute_id='.$eav->getIdByCode('catalog_product', 'haushaltsstelle'), array())
      	->joinleft(array('product_haushaltstelle'=>$this->getTable('paymentbase/haushaltsparameter')), 'product_haushaltstelle.paymentbase_haushaltsparameter_id=product_haushaltstelle_att.value' , array('haushaltstelle'=>'value'))
      	
       	->joinleft(array('product_kostenstl'=>'catalog_product_entity_varchar'), 'product_kostenstl.entity_id=main_table.product_id AND product_kostenstl.attribute_id='.$eav->getIdByCode('catalog_product', 'kostenstelle'), array())
       	->joinleft(array('product_kostenstelle'=>'eav_attribute_option_value'), 'product_kostenstelle.option_id=product_kostenstl.value AND product_kostenstelle.store_id=0',array('kostenstelle'=>'value'))
       	->joinleft(array('product_objektnummer_att'=>'catalog_product_entity_varchar'), 'product_objektnummer_att.entity_id=main_table.product_id AND product_objektnummer_att.attribute_id='.$eav->getIdByCode('catalog_product', 'objektnummer'), array())
      	->joinleft(array('product_objektnummer'=>$this->getTable('paymentbase/haushaltsparameter')), 'product_objektnummer.paymentbase_haushaltsparameter_id=product_objektnummer_att.value' , array('objektnummer'=>'value'))
      	 
      	
      	
      	->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id=main_table.order_item_id','tax_percent')
      	->joinleft(array('payment'=>'sales_flat_order_payment'), 'order.entity_id=payment.parent_id', array('kassenzeichen','method'))  
       	->columns($bewirtschafter)
      	->columns($konto)
      	->join(array('address'=>'sales_flat_order_address'),"address.parent_id=order.entity_id AND address.address_type ='billing'",array('fullcompany'=>$company,'fullname'=>$name,'address'=>$address,'country_id'))
      	 ;
      	 //die($collection3->getSelect()->__toString());    
      	
      	//Versankosten Gutschrift
      	$tax_percent = new Zend_Db_Expr('COALESCE(round(100 * `sales_flat_creditmemo`.`shipping_tax_amount` / `sales_flat_creditmemo`.`shipping_amount`),0.0000) as tax_percent');
      	$sql4 = new Zend_Db_Select($this->_select->getAdapter());
      	$sql4
      	->from('sales_flat_creditmemo',array('invoice_increment_id' => 'increment_id','invoice_date' => 'created_at','invoice_update'=> 'updated_at'))
      	->columns($versandGutschriftSKU)
      	->columns(new Zend_Db_Expr("1.0000 as qty"))
      	->columns(new Zend_Db_Expr("'Versand' as name"))
      	->columns(new Zend_Db_Expr("`sales_flat_creditmemo`.`shipping_amount` as price"))
      	->columns(new Zend_Db_Expr("`sales_flat_creditmemo`.`base_shipping_amount` as base_price"))
      	->columns(new Zend_Db_Expr("`sales_flat_creditmemo`.`shipping_amount` as row_total"))
      	->columns(new Zend_Db_Expr("`sales_flat_creditmemo`.`shipping_tax_amount` as base_tax_amount"))
      	->columns(new Zend_Db_Expr("`sales_flat_creditmemo`.`shipping_incl_tax` as price_incl_tax"))
      	->columns(new Zend_Db_Expr("`sales_flat_creditmemo`.`shipping_incl_tax` as row_total_incl_tax"))
      	->join(array('order'=>'sales_flat_order'),'order.entity_id=sales_flat_creditmemo.order_id',
      		array('order_increment_id' => 'increment_id','order_date' => 'created_at','customer_id','shipping_address_id','billing_address_id'))
      	->columns($versand)
      	->columns($hh_versand)
      	->columns($versand)
      	->columns($obj_versand)
      	->columns($tax_percent)
      	->joinleft(array('payment'=>'sales_flat_order_payment'), 'order.entity_id=payment.parent_id', array('kassenzeichen','method'))  
       	->columns($bewirtschafter)
      	->columns($konto)
      	->join(array('address'=>'sales_flat_order_address'),"address.parent_id=order.entity_id AND address.address_type ='billing'",array('fullcompany'=>$company,'fullname'=>$name,'address'=>$address,'country_id'))
      	->where('`sales_flat_creditmemo`.`shipping_amount` > 0');
      	
      	
      	$sql1 = $this->getSelect();
      	$sql3 = $collection3->getSelect();
      	
      	$sql = new Zend_Db_Select($this->_select->getAdapter());
      	$sql = $sql->union(array($sql1,$sql2,$sql3,$sql4),Zend_Db_Select::SQL_UNION_ALL);
      	$this->_select = new Varien_Db_Select($this->_select->getAdapter());
 		$this->_select->from($sql)->order('invoice_increment_id');
      
 		//die($this->getSelect()->__toString());  
        
        
        
        return $this;
    }
	
	
}