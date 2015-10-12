<?php
 class Dwd_Stationen_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup 
 {

 	public function getDefaultEntities() 
 	{
        return array(
            'stationen_stationen' => array(
                'entity_model' => 'stationen/stationen',
                'table' => 'stationen/stationen', 
                'attributes' => array(
                    'name' => array(
                        'type' => 'varchar',
                        'label' => 'Name',
                        'input' => 'text',
                        'required' => true,
                        'sort_order' => 10,
                        'position' => 10,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),  
                    
                    'stationskennung' => array(
                        'type' => 'static',
                        'label' => 'Name',
                        'input' => 'text',
                        'required' => true,
                        'sort_order' => 10,
                        'position' => 10,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),  
                    'description' => array(
                        'type' => 'varchar',
                        'label' => 'Description',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 20,
                        'position' => 20,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),   

                   'short_description' => array(
                        'type' => 'varchar',
                        'label' => 'Short Description',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 30,
                        'position' => 30,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),   
                    
                     'avail_from' => array(
                        'type' => 'static',
                        'label' => 'Avail From',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 40,
                        'position' => 40,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),  

                    'avail_to' => array(
                        'type' => 'static',
                        'label' => 'Avail From',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 40,
                        'position' => 40,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                    
                   'status' => array(
                        'type' => 'static',
                        'label' => 'Status',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 50,
                        'position' => 50,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                                       
                    'lat' => array(
                        'type' => 'static',
                        'label' => 'Latitude',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 60,
                        'position' => 60,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                    
                    'lon' => array(
                        'type' => 'static',
                        'label' => 'Longitude',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 70,
                        'position' => 70,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                    
                   'height' => array(
                        'type' => 'static',
                        'label' => 'Height',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 80,
                        'position' => 80,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),  

                   'override' => array(
                        'type' => 'static',
                        'label' => 'Override',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 90,
                        'position' => 90,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                   'mirakel_id' => array(
                        'type' => 'static',
                        'label' => 'Station ID',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 100,
                        'position' => 100,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),                     
                    'styp' => array(
                        'type' => 'static',
                        'label' => 'styp',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 110,
                        'position' => 110,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),         
                   'region' => array(
                        'type' => 'static',
                        'label' => 'Region',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 120,
                        'position' => 120,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),       
                    'landkreis' => array(
                        'type' => 'static',
                        'label' => 'Landkreis',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 130,
                        'position' => 130,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                   'gemeinde' => array(
                        'type' => 'static',
                        'label' => 'Gemeinde',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 140,
                        'position' => 140,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                   'messnetz' => array(
                        'type' => 'static',
                        'label' => 'Messnetz',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 150,
                        'position' => 150,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                    'ktyp' => array(
                        'type' => 'static',
                        'label' => 'KTyp',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 160,
                        'position' => 160,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),  
                   'land' => array(
                        'type' => 'static',
                        'label' => 'Land',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 160,
                        'position' => 160,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                                                           
                  
                	)	
 	    		),
 	    	   
 	    	'stationen_set' => array(
                'entity_model' => 'stationen/set',
                'table' => 'stationen/set', 
                'attributes' => array(
                    'name' => array(
                        'type' => 'varchar',
                        'label' => 'Name',
                        'input' => 'text',
                        'required' => true,
                        'sort_order' => 10,
                        'position' => 10,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),  
                    'description' => array(
                        'type' => 'varchar',
                        'label' => 'Description',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 20,
                        'position' => 20,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),   

                   'short_description' => array(
                        'type' => 'varchar',
                        'label' => 'Short Description',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 30,
                        'position' => 30,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    ),   
                    

                    
                   'status' => array(
                        'type' => 'static',
                        'label' => 'Status',
                        'input' => 'text',
                        'required' => false,
                        'sort_order' => 50,
                        'position' => 50,
                        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    ),   
                                                        
                	)	
 	    		)
 	    	);
 	    }
} 