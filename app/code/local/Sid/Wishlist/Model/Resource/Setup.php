<?php
/**
 * Model Resource-Setup
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
    /**
     * List of entities converted from EAV to flat data structure
     *
     * @var $_flatEntityTables array
     */
    protected $_flatEntityTables     = array(
        'quote'             => 'sidwishlist/quote',
        'quote_item'        => 'sidwishlist/quote_item',
    );

    /**
     * List of entities used with separate grid table
     *
     * @var $_flatEntitiesGrid array
     */
    protected $_flatEntitiesGrid     = array(
    );

    /**
     * Prüft ob die Tabelle als Flat-Table exisitiert
     *
     * @param string $table Tabellenname
     * 
     * @return bool
     */
    protected function _flatTableExist($table)
    {
        $tablesList = $this->getConnection()->listTables();
        return in_array(strtoupper($this->getTable($table)), array_map('strtoupper', $tablesList));
    }

    /**
     * Fügt ein entity attribute hinzu. 
     * 
     * <strong>Überschrieben für flat entities support</strong>
     *
     * @param int|string $entityTypeId Entity Type ID
     * @param string     $code         Attribute Code
     * @param array      $attr         Attribute
     * 
     * @return Sid_Wishlist_Model_Resource_Setup
     */
    public function addAttribute($entityTypeId, $code, array $attr)
    {
        if (isset($this->_flatEntityTables[$entityTypeId])
            && $this->_flatTableExist($this->_flatEntityTables[$entityTypeId])
        ) {
            $this->_addFlatAttribute($this->_flatEntityTables[$entityTypeId], $code, $attr);
            $this->_addGridAttribute($this->_flatEntityTables[$entityTypeId], $code, $attr, $entityTypeId);
        } else {
            parent::addAttribute($entityTypeId, $code, $attr);
        }
        return $this;
    }

    /**
     * Fügt Attribute als separate Spalte zu einer Tabelle hinzu
     *
     * @param string $table     Tabellenname
     * @param string $attribute Attributname
     * @param array  $attr      Attribute
     * 
     * @return Sid_Wishlist_Model_Resource_Setup
     */
    protected function _addFlatAttribute($table, $attribute, $attr)
    {
        $tableInfo = $this->getConnection()->describeTable($this->getTable($table));
        if (isset($tableInfo[$attribute])) {
            return $this;
        }
        $columnDefinition = $this->_getAttributeColumnDefinition($attribute, $attr);
        $this->getConnection()->addColumn($this->getTable($table), $attribute, $columnDefinition);
        return $this;
    }

    /**
     * Fügt, falls notwendig, Attribut zu Grid-Tabelle hinzu
     *
     * @param string $table        Tabellenname
     * @param string $attribute    Attributname
     * @param array  $attr         Attribute
     * @param string $entityTypeId Entity Type ID
     * 
     * @return Sid_Wishlist_Model_Resource_Setup
     */
    protected function _addGridAttribute($table, $attribute, $attr, $entityTypeId)
    {
        if (in_array($entityTypeId, $this->_flatEntitiesGrid) && !empty($attr['grid'])) {
            $columnDefinition = $this->_getAttributeColumnDefinition($attribute, $attr);
            $this->getConnection()->addColumn($this->getTable($table . '_grid'), $attribute, $columnDefinition);
        }
        return $this;
    }

    /**
     * Liefert die Definition einer Spalte zum Erstellen einer Flat-Table
     *
     * @param string $code Code
     * @param array  $data Daten
     * 
     * @return array
     */
    protected function _getAttributeColumnDefinition($code, $data)
    {
        // Convert attribute type to column info
        $data['type'] = isset($data['type']) ? $data['type'] : 'varchar';
        $type = null;
        $length = null;
        switch ($data['type']) {
            case 'timestamp':
                $type = Varien_Db_Ddl_Table::TYPE_TIMESTAMP;
                break;
            case 'datetime':
                $type = Varien_Db_Ddl_Table::TYPE_DATETIME;
                break;
            case 'decimal':
                $type = Varien_Db_Ddl_Table::TYPE_DECIMAL;
                $length = '12,4';
                break;
            case 'int':
                $type = Varien_Db_Ddl_Table::TYPE_INTEGER;
                break;
            case 'text':
                $type = Varien_Db_Ddl_Table::TYPE_TEXT;
                $length = 65536;
                break;
            case 'char':
            case 'varchar':
                $type = Varien_Db_Ddl_Table::TYPE_TEXT;
                $length = 255;
                break;
        }
        if ($type !== null) {
            $data['type'] = $type;
            $data['length'] = $length;
        }

        $data['nullable'] = isset($data['required']) ? !$data['required'] : true;
        $data['comment']  = isset($data['comment']) ? $data['comment'] : ucwords(str_replace('_', ' ', $code));
        return $data;
    }

    /**
     * Liefert Default-Entities
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        return array(
            'quote'=>array(
                'entity_model'  => 'sidwishlist/quote',
                'table'         => 'sidwishlist/quote',
                'attributes' => array(
                    'entity_id'             => array('type'=>'static'),
                	'is_default'             => array('type'=>'static'),
                    'is_active'             => array('type'=>'static'),
                    'store_id'              => array('type'=>'static'),
                    'remote_ip'             => array('type'=>'static'),
                    'password_hash'         => array('type'=>'static'),
                    'converted_at'          => array('type'=>'static'),
                    'orig_entity_id'		=> array('type'=>'static'),

                    'coupon_code'           => array('type'=>'static'),
                    'global_currency_code'  => array('type'=>'static'),
                    'base_currency_code'    => array('type'=>'static'),
                    'store_currency_code'   => array('type'=>'static'),
                    'quote_currency_code'   => array('type'=>'static'),
                    'store_to_base_rate'    => array('type'=>'static'),
                    'store_to_quote_rate'   => array('type'=>'static'),
                    'base_to_global_rate'   => array('type'=>'static'),
                    'base_to_quote_rate'    => array('type'=>'static'),

                    'items_count'           => array('type'=>'static'),
                    'items_qty'             => array('type'=>'static'),

                    'grand_total'           => array('type'=>'static'),
                    'base_grand_total'      => array('type'=>'static'),

                    'applied_rule_ids'      => array('type'=>'static'),

                    'is_virtual'            => array('type'=>'static'),

                    'customer_id'           => array('type'=>'static'),
                    'customer_tax_class_id' => array('type'=>'static'),
                    'customer_group_id'     => array('type'=>'static'),
                    'customer_email'        => array('type'=>'static'),
                    'customer_prefix'       => array('type'=>'static'),
                    'customer_firstname'    => array('type'=>'static'),
                    'customer_middlename'   => array('type'=>'static'),
                    'customer_lastname'     => array('type'=>'static'),
                    'customer_suffix'       => array('type'=>'static'),
                    'customer_note'         => array('type'=>'static'),
                    'customer_note_notify'  => array('type'=>'static'),
                    'customer_is_guest'     => array('type'=>'static'),
                    'customer_taxvat'       => array('type'=>'static'),
                    'customer_dob'          => array('type'=>'static'),
                    'customer_gender'       => array('type'=>'static'),
                	'customer_acls'       => array('type'=>'static'),
                ),
            ),

            'quote_item' => array(
                'entity_model'  => 'sidwishlist/quote_item',
                'table'         => 'sidwishlist/quote_item',
                'attributes'    => array(
                    'product_id'                => array('type'=>'static'),
                    'super_product_id'          => array('type'=>'static'),
                    'parent_product_id'         => array('type'=>'static'),
                	'converted_item_id'			=> array('type'=>'static'),
                    'sku'                       => array('type'=>'static'),
                    'name'                      => array('type'=>'static'),
                    'description'               => array('type'=>'static'),
                		
                	'converted_at'				=> array('type'=>'static'),
                		
                	'customer_id'				=> array('type'=>'static'),

                    'weight'                    => array('type'=>'static'),
                    'free_shipping'             => array('type'=>'static'),
                    'qty'                       => array('type'=>'static'),
                    'is_qty_decimal'            => array('type'=>'static'),

                    'price'                     => array('type'=>'static'),
                    'custom_price'              => array('type'=>'static'),
                    'discount_percent'          => array('type'=>'static'),
                    'discount_amount'           => array('type'=>'static'),
                    'no_discount'               => array('type'=>'static'),
                    'tax_percent'               => array('type'=>'static'),
                    'tax_amount'                => array('type'=>'static'),
                    'row_total'                 => array('type'=>'static'),
                    'row_total_with_discount'   => array('type'=>'static'),

                    'base_price'                => array('type'=>'static'),
                    'base_discount_amount'      => array('type'=>'static'),
                    'base_tax_amount'           => array('type'=>'static'),
                    'base_row_total'            => array('type'=>'static'),

                    'row_weight'                => array('type'=>'static'),
                    'applied_rule_ids'          => array('type'=>'static'),
                    'additional_data'           => array('type'=>'static'),
                ),
            ),
        );
    }
    
    /**
     * Erstellt das Email-Template in der Config
     *
     * @param array $emailData Daten
     *
     * @return void
     */
    public function createEmail($emailData) {
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
}
