<?php

class Egovs_SepaDebitSax_Block_Adminhtml_Customer_Edit_Tab_Sepa_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('blocks_form', array('legend'=>Mage::helper('pdftemplate')->__('Sepa Mandate')));
     
      
      $mandateid = $customer = Mage::registry('current_customer')->getSepaMandateId();
      //$mandateid = "MR140404DE98MVT099999999990110";
      if(!$mandateid)
      {
      	$fieldset->addField('sepa_mandate_id', 'text', array(
      			'label'     => Mage::helper('sepadebitsax')->__('SEPA Mandate Id'),
      			'class'     => 'readonly',
      			"readonly" => true,
      			'name'      => 'sepa_mandate_id',
      			"value" => "n/a"
      	));
      }
      else
      {
      	try {
      		$mandate = $model->getMandate($mandateid);
      	}
      	catch (Exception $ex)
      	{
      		$this->getMessagesBlock()->addError($ex);
      	}
      	
      	if($mandate)
      	{
	      $fieldset->addField('sepa_mandate_id', 'text', array(
	          'label'     => Mage::helper('sepadebitsax')->__('SEPA Mandate Id'),
	          'class'     => 'readonly',
	          "readonly" => true,
	          'name'      => 'sepa_mandate_id',
	      	"value" => $mandateid
	      ));
	      
	      $link = $this->getUrl("sepadebitsax/adminhtml_mandate/link",array("mandateid"=>$mandateid ));
	      
	      $fieldset->addField('sepa_mandate_link', 'link', array(
	          'label'     => Mage::helper('sepadebitsax')->__('Pdf'),
	          'name'      => 'title',
	      	  "href" => $link,
	      	  'value' =>'download'
	      ));
	      
	      $model = Mage::getModel('sepadebitsax/sepadebitsax');
	      /* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
	      $mandate = $model->getMandate($mandateid);
	      
	      $fieldset->addField('sepa_mandate_date_utz', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Date of last use'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_date_utz',
	      		"value" =>      $this->_dateToString( $mandate->getAdapteeMandate()->DatumLetzteNutzung),
	      ));
	      
	      $fieldset->addField('sepa_mandate_date_fall', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Date of the last maturity'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_date_fall',
	      		"value" =>     $this->_dateToString( $mandate->getAdapteeMandate()->DatumLetzteFaelligkeit),
	      ));
	      
	      
	      $fieldset->addField('sepa_mandate_date_kuen', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Date of cancellation'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_date_kuen',
	      		"value" =>      $this->_dateToString( $mandate->getAdapteeMandate()->DatumKuendigung),
	      ));
	      
	      $fieldset->addField('sepa_mandate_date_erst', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Date of creation'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_date_erst',
	      		"value" =>      $this->_dateToString( $mandate->getAdapteeMandate()->DatumErstellung),
	      ));
	      
	      
	      
	      $fieldset->addField('sepa_mandate_status', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Status'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_status',
	      		"value" => $mandate->getAdapteeMandate()->MandatStatus,
	      ));
	      
	      $fieldset->addField('remove_sepa_mandate', 'checkbox', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Remove and Close Mandate'),
	      		'name'      => 'remove_sepa_mandate',
	      
	      ));
	      
	      $fieldset = $form->addFieldset('blocks_debitor', array('legend'=>Mage::helper('pdftemplate')->__('Debitor')));
	      
	      $fieldset->addField('sepa_mandate_vormane', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('First Name'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_vormname',
	      		"value" => $mandate->getAdapteeMandate()->DebitorVorname,
	      ));
	      
	      $fieldset->addField('sepa_mandate_name', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Name'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_name',
	      		"value" => $mandate->getAdapteeMandate()->DebitorName,
	      ));
	      
	      $adr = $mandate->getAdapteeMandate()->DebitorAdresse;
	      
	      $fieldset->addField('sepa_mandate_str', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Street'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_str',
	      		"value" =>$adr->Strasse,
	      ));
	      
	      $fieldset->addField('sepa_mandate_plz', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Postal Code'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_plz',
	      		"value" =>$adr->Plz,
	      ));
	      

	      $fieldset->addField('sepa_mandate_pos', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('City'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_pos',
	      		"value" =>$adr->Stadt,
	      ));
	      
	      $fieldset->addField('sepa_mandate_land', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Country'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_land',
	      		"value" =>$adr->Land,
	      ));
	      
	      $fieldset->addField('sepa_mandate_pf', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('Mailbox'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_pf',
	      		"value" =>$adr->Postfach,
	      ));
	      
	      $ba = $mandate->getBankingAccount();
	      $fieldset->addField('sepa_mandate_iban', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('IBAN'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_iban',
	      		"value" =>$ba->getIban()
	      ));
	      

	      $fieldset->addField('sepa_mandate_bic', 'text', array(
	      		'label'     => Mage::helper('sepadebitsax')->__('BIC'),
	      		'class'     => 'readonly',
	      		"readonly" => true,
	      		'name'      => 'sepa_mandate_bic',
	      		"value" =>$ba->getBic(),
	      ));
	      
	      if(!$mandate->getAccountholderDiffers())
	      {
	     	 $fieldset->addField('sepa_mandate_diff', 'checkbox', array(
		      		'label'     => Mage::helper('sepadebitsax')->__('Customer is account holder'),
		      		'class'     => 'disabled=disabled',
		      		"readonly" => true,
		      		"disabled" => "disabled",
	     	 		"checked" => "checked",
		      		'name'      => 'sepa_mandate_diff',
		      		
		      ));
	      
	      }
	      if($mandate->getAccountholderDiffers())
	      {
	      	
	      	$fieldset->addField('sepa_mandate_diff', 'checkbox', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('Customer is account holder'),
	      			'class'     => 'disabled=disabled',
	      			"readonly" => true,
	      			"disabled" => "disabled",
	      			
	      			'name'      => 'sepa_mandate_diff',
	      	
	      	));
	      	
	      	$fieldset = $form->addFieldset('blocks_knto', array('legend'=>Mage::helper('pdftemplate')->__('account holder')));
	      	
	      	$fieldset->addField('sepa_mandate_vormane_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('First Name'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_vormname_konto',
	      			"value" => $mandate->getAdapteeMandate()->KontoinhaberVorname,
	      	));
	      	 
	      	$fieldset->addField('sepa_mandate_name_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('Name'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_name_konto',
	      			"value" => $mandate->getAdapteeMandate()->KontoinhaberName,
	      	));
	      	 
	      	$adr = $mandate->getAdapteeMandate()->KontoinhaberAdresse;
	      	 
	      	$fieldset->addField('sepa_mandate_str_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('Street'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_str_konto',
	      			"value" =>$adr->Strasse,
	      	));
	      	 
	      	$fieldset->addField('sepa_mandate_plz_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('Postal Code'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_plz_konto',
	      			"value" =>$adr->Plz,
	      	));
	      	 
	      	
	      	$fieldset->addField('sepa_mandate_pos_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('City'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_pos_konto',
	      			"value" =>$adr->Stadt,
	      	));
	      	 
	      	$fieldset->addField('sepa_mandate_land_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('Country'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_land_konto',
	      			"value" =>$adr->Land,
	      	));
	      	 
	      	$fieldset->addField('sepa_mandate_pf_konto', 'text', array(
	      			'label'     => Mage::helper('sepadebitsax')->__('Mailbox'),
	      			'class'     => 'readonly',
	      			"readonly" => true,
	      			'name'      => 'sepa_mandate_pf_konto',
	      			"value" =>$adr->Postfach,
	      	));
	      	 
	      }
	      	
	      	
	      }
	      
	      
      }
      
      return parent::_prepareForm();
  }
  
  private function _dateToString($date)
  {
  	if(strlen($date) == 0)
  	{
  		return "";
  	}
  	
  	return  date("d.m.Y", strtotime($date));
  	
  }
  
}