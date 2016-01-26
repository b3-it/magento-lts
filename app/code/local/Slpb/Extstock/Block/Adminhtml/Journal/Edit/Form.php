<?php

class Slpb_Extstock_Block_Adminhtml_Journal_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      $stock = Mage::getSingleton('Slpb_Extstock_Model_Stock');
      
      $model  = Mage::registry('extstock_journal_data');
      $product = Mage::getModel('catalog/product')->load($model->getProductId());
      $bestand = Mage::getResourceModel('extstock/detail_collection');
	  $bestand->getSelect()->where("product_id = ?", intval($model->getProductId()));
		
      
      
      
      $fieldset = $form->addFieldset('extstock_journal_form', array('legend'=>Mage::helper('extstock')->__('Stock Movement')));
		
      if($model->getStatus() != Slpb_Extstock_Model_Journal::STATUS_DELIVERED)
      {
	       $fieldset->addField('product_id', 'hidden', array(
	            'name'      => 'product_id',
	            'value'     => $model->getProductId(),
	        ));
	        
	       $fieldset->addField('grid', 'hidden', array(
	            'name'      => 'grid',
	            'value'     => $model->getGrid(),
	        ));
	      
	
	      $fieldset->addField('name', 'text', array(
	            'name'      => 'name',
	            'label'     => Mage::helper('extstock')->__('Product'),
	            'title'     => Mage::helper('extstock')->__('Product'),
	            //'required'  => true,
	      		//'class' => 'readonly',
	      		'disabled' => true,
	      		'readonly'	=> true,
	            'value'     => $product->getName(),
	        ));
	        
	       $fieldset->addField('sku', 'text', array(
	            'name'      => 'sku',
	            'label'     => Mage::helper('extstock')->__('Sku'),
	            'title'     => Mage::helper('extstock')->__('Sku'),
	            //'required'  => true,
	      		//'class' => 'required-entry',
	      		'disabled' => true,
	      		'readonly'	=> true,
	            'value'     => $product->getSku(),
	        ));
	
	  	 if($model->getOutputStockId() === null)
		 {
		 	$source = $stock->getSourceStockAsOptionsArray();
		 	//echo "<pre>"; var_dump($source); die();
		 	foreach($bestand->getItems() as $item)
		 	{
		 		$id = intval($item->getStockId());
		 		//echo "<pre>"; var_dump($item); die();
		 		if(isset($source[$id]))
		 		{
		 			$source[$id] = $source[$id] . "(".$item->getQty().")";
		 		}
		 	} 
			 $fieldset->addField('output_stock_id', 'select', array(
		          'label'     => Mage::helper('extstock')->__('Source'),
		          'name'      => 'output_stock_id',
			 	  'options'	  => $source,
			 	  'value'	  => 0,
			 ));
		 }else
		 {
		 	$output = $stock->getSourceStockAsOptionsArray(); 
		 	//echo "<pre>"; var_dump($output); die();
	     	$fieldset->addField('output_stock', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Source'),
	          'name'      => 'output_stock',
		 	  'value'	  => $output[$model->getOutputStockId()],
	      	  'readonly' 	=> true	
	     	));
		 }
	        
	      $input = $stock->getSourceStockAsOptionsArray();  
	     $fieldset->addField('input_stock_id', 'hidden', array(
	          
	          'name'      => 'input_stock_id',
		 	  'value'	  => $model->getInputStockId(),
	
		 ));
	     $fieldset->addField('input_stock', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Destination'),
	          'name'      => 'input_stock',
		 	  'value'	  => $input[$model->getInputStockId()],
	      	  'readonly' 	=> true	
		 ));
		 
		 
		     $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
	 
		    $fieldset->addField('exts_move_date_ordered', 'date', array(
		          'label'     	=> Mage::helper('extstock')->__('Order Date'),
		     	  'format' 		=> $dateFormatIso,//Varien_Date::DATE_INTERNAL_FORMAT,
		          'name'      	=> 'ordered',
			 	  'readonly'  	=> true,
		     	  'input_format'      => $dateFormatIso,
			      'value'		=> $model->getDateOrdered()	
		
			 ));
		     
		     
		     $fieldset->addField('exts_move_date_delivered', 'date', array(
		          'label'     	=> Mage::helper('extstock')->__('Delivery Date'),
		     	  'format' 		=> $dateFormatIso,//Varien_Date::DATE_INTERNAL_FORMAT,
		          'name'      	=> 'delivered',
			 	  //'required'  	=> true,
		      	  //'class' 		=> 'required-entry',
		     	  'image' 		=> $this->getSkinUrl('images/grid-cal.gif'),
		     	  'input_format'      => $dateFormatIso,
			      'value'		=> $model->getDateDelivered()	
		
			 ));
		     
		     
		     $fieldset->addField('qty_ordered', 'text', array(
		     		'name'      => 'qty',
		     		'label'     => Mage::helper('extstock')->__('Qty Ordered'),
		     		'title'     => Mage::helper('extstock')->__('Qty Ordered'),
		     		//'required'  => true,
		     		//'class' => 'required-entry',
		     		'readonly'	=> true,
		     		'disabled' => true,
		     		'value'     => $model->getQtyOrdered(),
		     ));
		     
		
			 $fieldset->addField('qty', 'text', array(
		            'name'      => 'qty',
		            'label'     => Mage::helper('extstock')->__('Qty Delivered'),
		            'title'     => Mage::helper('extstock')->__('Qty Delivered'),
		            'required'  => true,
		      		'class' => 'required-entry',
		      		//'readonly'	=> true,
		            'value'     => $model->getQtyOrdered(),
		        ));
			 
			$fieldset->addField('exts_move_status', 'select', array(
		          'label'     => Mage::helper('extstock')->__('Status'),
		          'name'      => 'status',
			 	  'options'	  => Slpb_Extstock_Model_Journal::getStatusOptionsArray(),
				  'value'	  => $model->getStatus()	
			 ));
			 
			 
			$fieldset->addField('exts_move_note', 'text', array(
		          'label'     => Mage::helper('extstock')->__('Note'),
		          'name'      => 'note',
				  'value'	  => $model->getNote()		
			 )); 
			 
      }else //Readonly
      {
      	
      	if($this->_parentBlock != null)
      	{
      		$this->_parentBlock->removeButton('save');
      	}
    
      $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('extstock')->__('Product'),
            'title'     => Mage::helper('extstock')->__('Product'),
         	'disabled' => true,
      		'readonly'	=> true,
            'value'     => $product->getName(),
        ));
        
       $fieldset->addField('sku', 'text', array(
            'name'      => 'sku',
            'label'     => Mage::helper('extstock')->__('Sku'),
            'title'     => Mage::helper('extstock')->__('Sku'),
             'disabled' => true,
      		'readonly'	=> true,
            'value'     => $product->getSku(),
        ));

  	 if($model->getOutputStockId() === null)
	 {
	 	$source = $stock->getSourceStockAsOptionsArray();
	 	//echo "<pre>"; var_dump($source); die();
	 	foreach($bestand->getItems() as $item)
	 	{
	 		$id = intval($item->getStockId());
	 		//echo "<pre>"; var_dump($item); die();
	 		if(isset($source[$id]))
	 		{
	 			$source[$id] = $source[$id] . "(".$item->getQty().")";
	 		}
	 	} 
		 $fieldset->addField('output_stock_id', 'select', array(
	          'label'     => Mage::helper('extstock')->__('Source'),
	          'name'      => 'output_stock_id',
		 	  'options'	  => $source,
		 	  'value'	  => 0,
		   	'disabled' => true,
      		'readonly'	=> true,
		 ));
	 }else
	 {
	 	$output = $stock->getSourceStockAsOptionsArray(); 
	 	//echo "<pre>"; var_dump($output); die();
     	$fieldset->addField('output_stock', 'text', array(
          'label'     => Mage::helper('extstock')->__('Source'),
          'name'      => 'output_stock',
	 	  'value'	  => $output[$model->getOutputStockId()],
     	  	'disabled' => true,
      		'readonly'	=> true,
     	));
	 }
        
      $input = $stock->getSourceStockAsOptionsArray();  
     $fieldset->addField('input_stock_id', 'hidden', array(
          
          'name'      => 'input_stock_id',
	 	  'value'	  => $model->getInputStockId(),
       	'disabled' => true,
      		'readonly'	=> true,

	 ));
     $fieldset->addField('input_stock', 'text', array(
          'label'     => Mage::helper('extstock')->__('Destination'),
          'name'      => 'input_stock',
	 	  'value'	  => $input[$model->getInputStockId()],
      	  'disabled' => true,
      		'readonly'	=> true,
	 ));
      	
      	    $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
	 
	    $fieldset->addField('exts_move_date_ordered', 'date', array(
	          'label'     	=> Mage::helper('extstock')->__('Order Date'),
	     	  'format' 		=> $dateFormatIso,//Varien_Date::DATE_INTERNAL_FORMAT,
	          'name'      	=> 'ordered',
		 	  	'disabled' => true,
      		'readonly'	=> true,
	     	  'input_format'      => $dateFormatIso,
		      'value'		=> $model->getDateOrdered()	
	
		 ));
	     
	     
	     $fieldset->addField('exts_move_date_delivered', 'date', array(
	          'label'     	=> Mage::helper('extstock')->__('Delivery Date'),
	     	  'format' 		=> $dateFormatIso,//Varien_Date::DATE_INTERNAL_FORMAT,
	          'name'      	=> 'delivered',
		 	 	'disabled' => true,
      		'readonly'	=> true,
	     	  'image' 		=> $this->getSkinUrl('images/grid-cal.gif'),
	     	  'input_format'      => $dateFormatIso,
		      'value'		=> $model->getDateDelivered()	
	
		 ));
	     
	     $fieldset->addField('qty_ordered', 'text', array(
	     		'name'      => 'qty',
	     		'label'     => Mage::helper('extstock')->__('Qty Ordered'),
	     		'title'     => Mage::helper('extstock')->__('Qty Ordered'),
	     		//'required'  => true,
	     		//'class' => 'required-entry',
	     		'readonly'	=> true,
	     		'disabled' => true,
	     		'value'     => $model->getQtyOrdered(),
	     ));
	      
	
		 $fieldset->addField('qty', 'text', array(
	            'name'      => 'qty',
	            'label'     => Mage::helper('extstock')->__('Qty Delivered'),
	            'title'     => Mage::helper('extstock')->__('Qty Delivered'),
	            'required'  => true,
	      		'class' => 'required-entry',
	      		'disabled' => true,
      			'readonly'	=> true,
	            'value'     => $model->getQty(),
	        ));
		 
		$fieldset->addField('exts_move_status', 'select', array(
	          'label'     => Mage::helper('extstock')->__('Status'),
	          'name'      => 'status',
		 	  'options'	  => Slpb_Extstock_Model_Journal::getStatusOptionsArray(),
			  'value'	  => $model->getStatus(),
			  'disabled' => true,
      		  'readonly'	=> true,	
		 ));
		 
		 
		$fieldset->addField('exts_move_note', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Note'),
	          'name'      => 'note',
			  'value'	  => $model->getNote()	,
			  'disabled' => true,
      		  'readonly'	=> true,	
		 )); 
		 
		 
		 
      	
      }
       


        
      return parent::_prepareForm();
  }
  
 
}