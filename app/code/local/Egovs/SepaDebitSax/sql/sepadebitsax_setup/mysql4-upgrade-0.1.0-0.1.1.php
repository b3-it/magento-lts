<?php
/** @var $this Egovs_Paymentbase_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();



$emailData = array();
$emailData['template_code'] = "Sepa Saxmandate Änderung (Template)";
$emailData['template_subject'] = "Ihre SEPA Mandatsänderung";
$emailData['config_data_path'] = "payment/sepadebitsax/mandate_amendment_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ihr SEPA Mandat</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name"
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
Sehr geehrte Kundin, <br/>
Sehr geehrter Kunde, <br/>
 <br/>
hiermit erhalten Sie im Anhang die Bestätigung der von Ihnen vorgenommen Änderungen an ihrem SEPA - Mandat. 
		 <br/>
Vielen Dank
 <br/>
Ihr {{config path="general/store_information/name"}}
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