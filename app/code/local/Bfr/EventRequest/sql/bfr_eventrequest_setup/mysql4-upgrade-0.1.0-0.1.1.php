<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();


$allEmailData = array();

$emailData = array();
$emailData['template_code'] = "Application rejected (Template)";
$emailData['template_subject'] = "Application rejected";
$emailData['config_data_path'] = "eventrequest/email/eventrequest_reject_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ihre Bewerbung wurde abgelehnt</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name",
"store url="customer/account/"":"Customer Account Url",
"var customer.email":"Customer Email",
"var product.name":"Product Name" 
}
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
							<a href="{{store url=""}}"><img src="{{skin url="images/logo_email_dwd.gif" _area="frontend"}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a>
						</td>
					</tr>
				</table>
				<!-- [ middle starts here] -->
				<table cellspacing="0" cellpadding="0" border="0" width="650">
					<tr>
						<td valign="top">
							<p>
							Your Request to {{var product.name}} has been rejected!
							</p>
							<p>
							Ihre Bewerbung für {{var product.name}} wurde abgelehnt!
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