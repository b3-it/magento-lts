<?php
/**
 * Dwd Abo
 *
 *
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo Installer
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('dwd_abo/abo')};
CREATE TABLE {$this->getTable('dwd_abo/abo')} (
  `abo_id` int(11) unsigned NOT NULL auto_increment,
  `first_order_id` int(11) unsigned default NULL,
  `first_orderitem_id` int(11) unsigned default NULL,
  `current_order_id` int(11) unsigned default NULL,
  `current_orderitem_id` int(11) unsigned default NULL,
  `renewal_status` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `start_date` datetime NULL,
  `stop_date` datetime NULL,
  `cancelation_period_end` datetime NULL,
  PRIMARY KEY (`abo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


$allEmailData = array();

$emailData = array();
$emailData['template_code'] = "Abonnement ist nicht mehr verfügbar (Template)";
$emailData['template_subject'] = "Ihr Abonnement ist nicht mehr verfügbar";
$emailData['config_data_path'] = "dwd_abo/email/notavailable_abo_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kuendigungsbestaetigung</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name",
"store url="customer/account/"":"Customer Account Url",
"var customer.email":"Customer Email",
"htmlescape var=$customer.password":"Customer Password"}
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
							  <strong>Sehr geehrte/er {{htmlescape var=$customer.getPrefix()}} {{htmlescape var=$customer.getLastname()}}</strong>,<br/>
                leider ist die Verlängerung Ihres Abonnements „{{htmlescape var=$orderitem.getName()}}, {{htmlescape var=$station.getName()}}“
                mit der Bestellnummer {{var order.increment_id}} vom {{var order.getCreatedAtFormated("short")}} nicht möglich, da dieses
                Produkt in der von Ihnen gewünschten Form nicht mehr existiert.
              </p>
              <p>
                Ihr Abonnement wurde aus diesem Grund storniert. Zukünftig werden Sie auch keinen Newsletter mehr für dieses Produkt erhalten.
              </p>
              <p>
                Falls Sie Interesse an einem alternativen Produkt haben sollten, können sie sich gern an ihren Produktbetreuer unter
                <a href="mailto:{{htmlescape var=$product.getBearbeiterEmail()}}" style="color:#1E7EC8;">{{htmlescape var=$product.getBearbeiterEmail()}}</a>
                wenden oder selbst im <a href="{{store url="index.php/"}}" style="color:#1E7EC8;">Wettershop</a> stöbern.
              </p>

              <p>Mit freundlichen Grüßen</p>
              <p>
                <strong>{{block type="imprint/field" value="shop_name"}}</strong><br>
                {{block type="imprint/field" value="company_first"}}
              </p>
              <p>Postfach 100465<br>63067 Offenbach</p>
					  </td>
					</tr>
					<tr>
            <td style="border-bottom:2px solid #eee;">&nbsp;</td>
          </tr>
					<tr>
						<td style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;">
		          Es gelten die <a href="{{store url="agb/"}}" target="_blank" style="color:#1E7EC8;">Allgemeinen Geschäftsbedingungen</a> des DWD.
		        </td>
					</tr>
          <tr>
						<td style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;">
		          Als Verbraucher haben Sie ein gesetzliches <a href=\"{{store url="index.php/widerruf/"}}\" target="_blank" style="color:#1E7EC8;">Widerrufsrecht</a>.
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

$emailData = array();
$emailData['template_code'] = "Kündigung Abonnement (Template)";
$emailData['template_subject'] = 'Kündigung für Ihr Abonnement {{htmlescape var=$product.getName()}}.';
$emailData['config_data_path'] = "dwd_abo/email/cancel_abo_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kuendigungsbestaetigung</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name",
"store url="customer/account/"":"Customer Account Url",
"var customer.email":"Customer Email",
"htmlescape var=$customer.password":"Customer Password"}
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
							  <strong>Sehr geehrte/er  {{htmlescape var=$customer.getPrefix()}} {{htmlescape var=$customer.getLastname()}}</strong>,<br/>
                Ihre Kündigung vom {{var now}} haben wir erhalten. Wunschgemäß haben wir das von Ihnen bestellte Abonnement
                „{{htmlescape var=$product.getName()}}, {{htmlescape var=$station.getName()}}“ mit der Bestellnummer {{var order.increment_id}}
                vom {{var order.getCreatedAtFormated("short")}} zum nächstmöglichen Termin gekündigt. Ihr Abonnement läuft somit am
                {{htmlescape var=$item.getStopDateFormated()}} aus.
              </p>
              <p>
                Sollten Sie noch Fragen oder Anregungen haben, können Sie diese an <a href="mailto:{{htmlescape var=$product.getBearbeiterEmail()}}" style="color:#1E7EC8;">
                {{htmlescape var=$product.getBearbeiterEmail()}}</a> richten.
              </p>
              <p>Mit freundlichen Grüßen</p>
              <p>
                <strong>{{block type="imprint/field" value="shop_name"}}</strong><br>
                {{block type="imprint/field" value="company_first"}}
              </p>
              <p>Postfach 100465<br>63067 Offenbach</p>
					  </td>
					</tr>
					<tr>
					  <td style="border-bottom:2px solid #eee;">&nbsp;</td>
          </tr>
					<tr>
						<td style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;">
		          Es gelten die <a href= \"{{store url="agb/"}}\" target="_blank" style="color:#1E7EC8;">Allgemeinen Geschäftsbedingungen</a> des DWD.
		        </td>
					</tr>
          <tr>
						<td style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;">
		          Als Verbraucher haben Sie ein gesetzliches <a href=\"{{store url="index.php/widerruf/"}}\" target="_blank" style="color:#1E7EC8;">Widerrufsrecht</a>.
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


$emailData = array();
$emailData['template_code'] = "Verlängerung Abonnement (Template)";
$emailData['template_subject'] = 'Ihr Abonnement {{htmlescape var=$product.getName()}} läuft aus!';
$emailData['config_data_path'] = "dwd_abo/email/renewal_abo_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unbenanntes Dokument</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name",
"store url="customer/account/"":"Customer Account Url",
"var customer.email":"Customer Email",
"htmlescape var=$customer.password":"Customer Password"}
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
							  <strong>Sehr geehrte/er  {{htmlescape var=$customer.getPrefix()}} {{htmlescape var=$customer.getLastname()}}</strong>,<br/>
						    Ihr Abonnement &bdquo;{{htmlescape var=$product.getName()}}, {{htmlescape var=$station.getName()}}&ldquo; mit der Bestellnummer
						    {{var order.increment_id}} vom {{var order.getCreatedAtFormated("short")}} läuft am {{htmlescape var=$item.getStopDate()}} aus.
						    Da Ihr Abonnement aufgrund  der von Ihnen verwendeten Bezahlmethode nicht automatisch verlängerbar ist,  wird Ihr Abonnement
						    nach dem {{htmlescape var=$item.getStopDate()}} auslaufen.
						  </p>
						  <p>
						    Wenn Sie Ihr Abonnement weiterhin beziehen möchten, müssen Sie Ihr Abonnement daher neu bestellen.
						  </p>
							<p>
							  Bitte gehen Sie hierfür bis zum {{htmlescape var=$item.getStopDate()}} auf <a href="{{htmlescape var=$product.getUrlPath()}}" style="color:#1E7EC8;">
							  {{htmlescape var=$product.getName()}}</a> und bestellen Sie Ihr Abonnement erneut.
							</p>
							<p>
							  Sollten Sie noch Fragen oder Anregungen haben, können Sie diese an <a href="mailto:{{htmlescape var=$product.getBearbeiterEmail()}}" style="color:#1E7EC8;">
							  {{htmlescape var=$product.getBearbeiterEmail()}}</a> richten.
							</p>
							<p>Mit freundlichen Grüßen</p>
              <p>
                <strong>{{block type="imprint/field" value="shop_name"}}</strong><br>
                {{block type="imprint/field" value="company_first"}}
              </p>
              <p>Postfach 100465<br>63067 Offenbach</p>
					  </td>
					</tr>
					<tr>
					  <td style="border-bottom:2px solid #eee;">&nbsp;</td>
          </tr>
					<tr>
						<td style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;">
		          Es gelten die <a href=\"{{store url="agb/"}}\" target="_blank" style="color:#1E7EC8;">Allgemeinen Geschäftsbedingungen</a> des DWD.
		        </td>
					</tr>
          <tr>
						<td style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;">
		          Als Verbraucher haben Sie ein gesetzliches <a href=\"{{store url="index.php/widerruf/"}}\" target="_blank" style="color:#1E7EC8;">Widerrufsrecht</a>.
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

$emailData = array();
$emailData['template_code'] = "Abonnement Kündigung wegen Rabattierung verhindert (Template)";
$emailData['template_subject'] = "Kündigung eines Abos wurde wegen Rabatt verhindert";
$emailData['config_data_path'] = "dwd_abo/email/cancel_abo_denied_template";
$emailData['template_type'] = "2";
$emailData['text'] = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kuendigungsbestaetigung</title>
</head>

<body>
<!--@vars
{"store url=""":"Store Url",
"skin url="images/logo_email.gif" _area="frontend"":"Email Logo Image",
"htmlescape var=$customer.name":"Customer Name",
"store url="customer/account/"":"Customer Account Url",
"var customer.email":"Customer Email",
"htmlescape var=$customer.password":"Customer Password"}
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
							  Der Kunde mit der Kennung {{htmlescape var=$customer.getEmail()}} hat versucht, das Abonnement „{{htmlescape var=$product.getName()}},
							  {{htmlescape var=$station.getName()}}“ mit der Bestellnummer {{var order.increment_id}} vom {{var order.getCreatedAtFormated("short")}}
							  zu kündigen. Die Kündigung wurde aufgrund der Inanspruchnahme von Rabatten abgelehnt.
							</p>
							<p>
							  Bitte prüfen Sie den Kündigungswunsch des Kunden und die damit verbundenen Rabatte der übrigen bestehenden Abos des Kunden. Bitte setzen
							  Sie sich nach Ihrer Prüfung mit dem Kunden in Verbindung.
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