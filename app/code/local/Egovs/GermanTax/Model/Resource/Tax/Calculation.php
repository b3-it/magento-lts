<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Resource_Tax_Calculation extends Mage_Tax_Model_Resource_Calculation
{
	/**
	 * Returns tax rates for request - either pereforms SELECT from DB, or returns already cached result
	 * Notice that productClassId due to optimization can be array of ids
	 *
	 * @param Varien_Object $request
	 * @return array
	 */
	protected function _getRates($request)
	{
		// Extract params that influence our SELECT statement and use them to create cache key
		$storeId = Mage::app()->getStore($request->getStore())->getId();
		$customerClassId = $request->getCustomerClassId();
		$countryId = $request->getCountryId();
		$regionId = $request->getRegionId();
		$postcode = $request->getPostcode();
		$isVirtual = $request->getIsVirtual();
		$taxvat = $request->getTaxvat();
	
		// Process productClassId as it can be array or usual value. Form best key for cache.
		$productClassId = $request->getProductClassId();
		$ids = is_array($productClassId) ? $productClassId : array($productClassId);
		foreach ($ids as $key => $val) {
			$ids[$key] = (int) $val; // Make it integer for equal cache keys even in case of null/false/0 values
		}
		$ids = array_unique($ids);
		sort($ids);
		$productClassKey = implode(',', $ids);
	
		// Form cache key and either get data from cache or from DB
		$cacheKey = implode('|', array($storeId, $customerClassId, $productClassKey, $countryId, $regionId, $postcode, $isVirtual, $taxvat));
	
		if (!isset($this->_ratesCache[$cacheKey])) {
			// Make SELECT and get data
			$select = $this->_getReadAdapter()->select();
			
			$select
				->from(array('main_table' => $this->getMainTable()),
						array(  'tax_calculation_rate_id',
								'tax_calculation_rule_id',
								'customer_tax_class_id',
								'product_tax_class_id'
						)
				)
				->where('customer_tax_class_id = ?', (int)$customerClassId);
			if ($productClassId) {
				$select->where('product_tax_class_id IN (?)', $productClassId);
			} else {
				$select->where('product_tax_class_id is null');
			}
			$ifnullTitleValue = $this->_getReadAdapter()->getCheckSql(
					'title_table.value IS NULL',
					'rate.code',
					'title_table.value'
			);
			$ruleTableAliasName = $this->_getReadAdapter()->quoteIdentifier('rule.tax_calculation_rule_id');

			$select
				->join(
					array('rule' => $this->getTable('tax/tax_calculation_rule')),
					$ruleTableAliasName . ' = main_table.tax_calculation_rule_id',
					array('rule.priority', 'rule.position', 'rule.calculate_subtotal', 'rule.valid_taxvat', 'tax_key' => 'rule.taxkey')
				);
			$select->join(
					array('rate'=>$this->getTable('tax/tax_calculation_rate')),
					'rate.tax_calculation_rate_id = main_table.tax_calculation_rate_id',
					array(
						'value' => 'rate.rate',
						'rate.tax_country_id',
						'rate.tax_region_id',
						'rate.tax_postcode',
						'rate.tax_calculation_rate_id',
						'rate.code'
					)
				)->joinLeft(
					array('title_table' => $this->getTable('tax/tax_calculation_rate_title')),
					"rate.tax_calculation_rate_id = title_table.tax_calculation_rate_id "
					. "AND title_table.store_id = '{$storeId}'",
					array('title' => $ifnullTitleValue)
				)->where('rate.tax_country_id = ?', $countryId)
				->where("rate.tax_region_id IN(?)", array(0, (int)$regionId)
			);
			if ($taxvat) {
				$select->where('rule.valid_taxvat = 1');
			} else {
				$select->where('rule.valid_taxvat = 0');
			}
			//die($select->assemble());				
			$postcodeIsNumeric = is_numeric($postcode);
			$postcodeIsRange = is_string($postcode) && preg_match('/^(.+)-(.+)$/', $postcode, $matches);
			if ($postcodeIsRange) {
				$zipFrom = $matches[1];
				$zipTo = $matches[2];
			}
	
			if ($postcodeIsNumeric || $postcodeIsRange) {
				$selectClone = clone $select;
				$selectClone->where('rate.zip_is_range IS NOT NULL');
			}
			$select->where('rate.zip_is_range IS NULL');
		
	        if ($postcode != '*' || $postcodeIsRange) {
				$select
					->where("rate.tax_postcode IS NULL OR rate.tax_postcode IN('*', '', ?)",
						$postcodeIsRange ? $postcode : $this->_createSearchPostCodeTemplates($postcode));
	            if ($postcodeIsNumeric) {
					$selectClone
						->where('? BETWEEN rate.zip_from AND rate.zip_to', $postcode);
				} else if ($postcodeIsRange) {
				$selectClone->where('rate.zip_from >= ?', $zipFrom)
					->where('rate.zip_to <= ?', $zipTo);
				}
	        }
		
	        /**
			 * @see ZF-7592 issue http://framework.zend.com/issues/browse/ZF-7592
			 */
			if ($postcodeIsNumeric || $postcodeIsRange) {
				$select = $this->_getReadAdapter()->select()->union(
					array(
						'(' . $select . ')',
						'(' . $selectClone . ')'
					)
				);
			}
		
			$select->order('priority ' . Varien_Db_Select::SQL_ASC)
				->order('valid_taxvat ' . Varien_Db_Select::SQL_DESC)
				->order('tax_calculation_rule_id ' . Varien_Db_Select::SQL_ASC)
				->order('tax_country_id ' . Varien_Db_Select::SQL_DESC)
				->order('tax_region_id ' . Varien_Db_Select::SQL_DESC)
				->order('tax_postcode ' . Varien_Db_Select::SQL_DESC)
	            ->order('value ' . Varien_Db_Select::SQL_DESC);
			
		//die($select->assemble());
		
			$this->_ratesCache[$cacheKey] = $this->_getReadAdapter()->fetchAll($select);
        }
	
        return $this->_ratesCache[$cacheKey];
	}
	
	/**
	 * Retrieve Calculation Process
	 *
	 * @param Varien_Object $request Tax Request
	 * @param array         $rates   Rates
	 * 
	 * @return array
	 */
    public function getCalculationProcess($request, $rates = null)
    {
        if (is_null($rates)) {
            $rates = $this->_getRates($request);
        }

        $result = array();
        $row = array();
        $ids = array();
        $currentRate = 0;
        $totalPercent = 0;
        $countedRates = count($rates);
        
        $taxvatRates = array();
        
        for ($i = 0; $i < $countedRates; $i++) {
            $rate = $rates[$i];
            
            $taxvatRate = null;
            if ($request && $request->getTaxvat()) {
            	if (isset($rate['valid_taxvat']) && 1 == $rate['valid_taxvat']) {
            		$taxvatRate = array(
            				'index' => $i,
            				'priority' => $rate['priority'],
            				'tax_country_id' => $rate['tax_country_id'],
            				'tax_region_id' => $rate['tax_region_id'],
            				'tax_postcode' => $rate['tax_region_id'],
            				//'product_tax_class_id' kann in SQL-Abfrage auch Array sein!
            				'product_tax_class_id' => $rate['product_tax_class_id'],
            		);
            		$taxvatRates[] = $taxvatRate;
            	} elseif (isset($rate['valid_taxvat']) && 0 == $rate['valid_taxvat']) {
            		continue;
            	} else {
            		foreach ($taxvatRates as $tvr) {
            			if ($tvr['priority'] == $rate['priority']
            					&& $tvr['product_tax_class_id'] == $rate['product_tax_class_id']
            					&& $tvr['tax_country_id'] == $rate['tax_country_id']
            					&& $tvr['tax_region_id'] == $rate['tax_region_id']
            					&& $tvr['tax_postcode'] == $rate['tax_postcode']
            			) {
            				//Entsprechende Steuer wurde bereits behandelt!
            				continue 2;
            			}
            		}
            	}
            }
            
            $value = (isset($rate['value']) ? $rate['value'] : $rate['percent']) * 1;

            $oneRate = array(
                'code' => $rate['code'],
                'title' => $rate['title'],
                'percent' => $value,
                'position' => $rate['position'],
                'priority' => $rate['priority'],
            );
            if (isset($rate['tax_calculation_rule_id'])) {
                $oneRate['rule_id'] = $rate['tax_calculation_rule_id'];
            }
            
            if (isset($rate['tax_key'])) {
            	$oneRate['tax_key'] = $rate['tax_key'];
            }

            if (isset($rate['hidden'])) {
                $row['hidden'] = $rate['hidden'];
            }

            if (isset($rate['amount'])) {
                $row['amount'] = $rate['amount'];
            }

            if (isset($rate['base_amount'])) {
                $row['base_amount'] = $rate['base_amount'];
            }
            if (isset($rate['base_real_amount'])) {
                $row['base_real_amount'] = $rate['base_real_amount'];
            }
            $row['rates'][] = $oneRate;

            if (isset($rates[$i + 1]['tax_calculation_rule_id'])) {
                $rule = $rate['tax_calculation_rule_id'];
            }
            $priority = $rate['priority'];
            $ids[] = $rate['code'];

            if (isset($rates[$i + 1]['tax_calculation_rule_id'])) {
                while (isset($rates[$i + 1]) && $rates[$i + 1]['tax_calculation_rule_id'] == $rule) {
                    $i++;
                }
            }

            $currentRate += $value;

            if (isset($rates[$i+1]) && $rates[$i+1]['priority'] != $priority) {
            	$taxvatRates = array();
            }
            
            if (!isset($rates[$i + 1]) || $rates[$i + 1]['priority'] != $priority
                || (isset($rates[$i + 1]['process']) && $rates[$i + 1]['process'] != $rate['process'])
            ) {
                if (!empty($rates[$i]['calculate_subtotal'])) {
                    $row['percent'] = $currentRate;
                    $totalPercent += $currentRate;
                } else {
                    $row['percent'] = $this->_collectPercent($totalPercent, $currentRate);
                    $totalPercent += $row['percent'];
                }
                $row['id'] = implode($ids);
                $result[] = $row;
                $row = array();
                $ids = array();

                $currentRate = 0;
            }
        }

        if (empty($result)) {
            $msg = sprintf("tax::calculation_process:EMPTY RESULT\nRequest:\n%s", var_export($result, true));
            Mage::log($msg, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
        }
        return $result;
    }
}