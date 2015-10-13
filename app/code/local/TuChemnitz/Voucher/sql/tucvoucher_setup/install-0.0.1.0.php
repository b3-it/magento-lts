<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'tucvoucher/tan'
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('tucvoucher/tan'))
	->addColumn('tan_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
			'autoincrement' => true,
			), 'Purchased ID')
	->addColumn('tan', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'Tan')
	->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'default'   => '0',
			), 'Order ID')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'unsigned'  => true,
					'default'   => '0',
			), 'Status')			
	->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
			), 'Order Item ID')
	->addColumn('expire', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
					'default'  => 'null',
			), 'Date of Expiration')
	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
			), 'Date of creation')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
			), 'Date of modification')
	->addForeignKey(
		$installer->getFkName('tucvoucher/tan', 'product_id', 'catalog/product', 'entity_id'),
		'product_id', $installer->getTable('catalog/product'), 'entity_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	/*
	->addForeignKey(
		$installer->getFkName('tucvoucher/tan', 'quote_item_id', 'sales/quote_item', 'item_id'),
		'quote_item_id', $installer->getTable('sales/quote_item'), 'item_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	*/
	->setComment('Tuc Voucher Table')
;


$installer->getConnection()->createTable($table);


$emailData = array();
$emailData['template_code'] = "Gutscheinversand (Template)";
$emailData['template_subject'] = "Ihre Gutscheine";
$emailData['config_data_path'] = "tucvoucher/email/tan_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ihre Gutscheine</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$order.customername":"Customer Name",
"var order.customeremail":"Customer Email",
		"var order":"Order",
		"var items[0]=>item": "Order Item",
		"var items[0]=>tan": "Tan"
"}
@-->

<!--@styles
	body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }
	a { color:#1E7EC8; }
@-->

<div style="font:11px/1.35em Verdana, Arial, Helvetica, sans-serif;">
	<table cellspacing="0" cellpadding="0" border="0" width="98%" style="margin-top:10px; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px;">
		<tr>
			<td align="center" valign="top">
				<!-- [ header starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area="frontend"}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a>
						</td>
					</tr>
				</table>
				<!-- [ middle starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<p>
							 Hiermit erhalten Sie zu Ihrer  Bestellung vom {{var order.getCreatedAtFormated("short")}} mit der Bestellnummer {{var order.increment_id}} ihre Tans.
							</p>
							<p>
							    {{block type="tucvoucher/email_tans" items="$items"}}
							</p>
		        </td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
';

$allEmailData[] = $emailData;






foreach ($allEmailData as $emailData){
	$model = Mage::getModel('core/email_template');
	$template = $model->setTemplateSubject($emailData['template_subject'])
	->setTemplateCode($emailData['template_code'])
	->setTemplateText($emailData['text'])
	->setTemplateType($emailData['template_type'])
	->setModifiedAt(Mage::getSingleton('core/date')->gmtDate())
	->save()
	;

	$this->setConfigData($emailData['config_data_path'], $template->getId());


}





$installer->endSetup();