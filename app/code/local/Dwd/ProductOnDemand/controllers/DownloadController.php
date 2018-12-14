<?php
require_once 'Mage/Downloadable/controllers/DownloadController.php';
class Dwd_ProductOnDemand_DownloadController extends Mage_Downloadable_DownloadController
{
	protected function _processDownload($resource, $resourceType)
	{
		$helper = Mage::helper('prondemand/downloadable_download');
		/* @var $helper Mage_Downloadable_Helper_Download */

		$helper->setResource($resource, $resourceType);

		$fileName       = $helper->getFilename();
		$contentType    = $helper->getContentType();

		$this->getResponse()
			->setHttpResponseCode(200)
			->setHeader('Pragma', 'public', true)
			->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
			->setHeader('Content-type', $contentType, true);

		if ($fileSize = $helper->getFilesize()) {
			$this->getResponse()
			->setHeader('Content-Length', $fileSize);
		}

		if ($contentDisposition = $helper->getContentDisposition()) {
			$this->getResponse()
			->setHeader('Content-Disposition', $contentDisposition . '; filename='.$fileName);
		}

		$this->getResponse()
			->clearBody();
		$this->getResponse()
			->sendHeaders();

		$helper->output();
	}
	
    /**
     * Download link action
     */
    public function linkAction()
    {
        $id = $this->getRequest()->getParam('id', 0);
        $linkPurchasedItem = Mage::getModel('downloadable/link_purchased_item')->load($id, 'link_hash');
        if (! $linkPurchasedItem->getId() ) {
            $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__("Requested link does not exist."));
            return $this->_redirect('downloadable/customer/products');
        }
        if (!Mage::helper('downloadable')->getIsShareable($linkPurchasedItem)) {
            $customerId = $this->_getCustomerSession()->getCustomerId();
            if (!$customerId) {
                $product = Mage::getModel('catalog/product')->load($linkPurchasedItem->getProductId());
                if ($product->getId()) {
                    $notice = Mage::helper('downloadable')->__(
                        'Please log in to download your product or purchase <a href="%s">%s</a>.',
                        $product->getProductUrl(), $product->getName()
                    );
                } else {
                    $notice = Mage::helper('downloadable')->__('Please log in to download your product.');
                }
                $this->_getCustomerSession()->addNotice($notice);
                $this->_getCustomerSession()->authenticate($this);
                $this->_getCustomerSession()->setBeforeAuthUrl(Mage::getUrl('downloadable/customer/products/'),
                    array('_secure' => true)
                );
                return ;
            }
            $linkPurchased = Mage::getModel('downloadable/link_purchased')->load($linkPurchasedItem->getPurchasedId());
            if ($linkPurchased->getCustomerId() != $customerId) {
                $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__("Requested link does not exist."));
                return $this->_redirect('downloadable/customer/products');
            }
        }
        $downloadsLeft = $linkPurchasedItem->getNumberOfDownloadsBought()
            - $linkPurchasedItem->getNumberOfDownloadsUsed();

        $this->_validate($linkPurchasedItem);
        $status = $linkPurchasedItem->getStatus();
        if ($status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_AVAILABLE
            && ($downloadsLeft || $linkPurchasedItem->getNumberOfDownloadsBought() == 0)
        ) {
            $resource = '';
            $resourceType = '';
            if ($linkPurchasedItem->getLinkType() == Mage_Downloadable_Helper_Download::LINK_TYPE_URL) {
                $resource = $linkPurchasedItem->getLinkUrl();
                $resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_URL;
            } elseif ($linkPurchasedItem->getLinkType() == Mage_Downloadable_Helper_Download::LINK_TYPE_FILE) {
                $resource = Mage::helper('downloadable/file')->getFilePath(
                    Mage_Downloadable_Model_Link::getBasePath(), $linkPurchasedItem->getLinkFile()
                );
                $resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
            }
            try {
                $this->_processDownload($resource, $resourceType);
                $linkPurchasedItem->setNumberOfDownloadsUsed($linkPurchasedItem->getNumberOfDownloadsUsed() + 1);

                if (($linkPurchasedItem->getNumberOfDownloadsBought() != 0 && !($downloadsLeft - 1))) {
                    $linkPurchasedItem->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED);
                }
                $linkPurchasedItem->save();
                exit(0);
            }
            catch (Exception $e) {
            	Mage::log("\n" . $e->__toString(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
                $this->_getCustomerSession()->addError(
                    Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
                );
            }
        } elseif ($status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED) {
            $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__('The link has expired.'));
        } elseif ($status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING
            || $status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PAYMENT_REVIEW
        ) {
            $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__('The link is not available.'));
        } else {
            $this->_getCustomerSession()->addError(
                Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
            );
        }
        return $this->_redirect('downloadable/customer/products');
    }
    
    /**
     * Setzt bzw. validiert das valid_to Feld
     * 
     * @param Mage_Downloadable_Model_Link_Purchased_Item $item Purchased Item
     * 
     * @return bool
     */
    protected function _validate($item) {
    	if (!$item) {
    		return false;
    	}
    	
    	if (!$item->hasValidTo()) {
    		$product = Mage::getModel('catalog/product')->load($item->getProductId(), array('pod_storage_time'));
    		
    		if (!$product->hasPodStorageTime()) {
    			return true;
    		}
    		
    		//Zeit in Tagen
    		$storageTime = $product->getPodStorageTime();
    		//Tage in Sekunden
            /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
            $storageTime = $storageTime * 86400;
    		$validTo = date(Varien_Date::DATETIME_PHP_FORMAT, time() + $storageTime);
    		$item->setValidTo($validTo);
    	}
    	
    	$result = strtotime($item->getValidTo()) > time();
    	
    	if (!$result) {
    		$item->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED);
    	}
    	
    	return $result;
    }

}
