<?php

require_once "AtomFeed/bootstrap.php";

class Bfr_EventFeed_FeedController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        /**
         * @var Mage_Catalog_Model_Resource_Product_Collection $collection
         */
        $collection = Mage::getModel('catalog/product')->getCollection();

        // only event bundle products which has eventatom_export enabled
        $collection->addAttributeToFilter('type_id',Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
        $collection->addAttributeToFilter('eventfeed_export',"1");

        // add store filter for the current store
        $collection->addStoreFilter(null);

        // add attributes to select which can be added to atom
        $collection->addAttributeToSelect([
            'name','description','short_description', 'productfile', 'date_disable'
        ]);

        // Join with Event to get Beginn
        $collection->joinTable('eventmanager/event', "product_id=entity_id", 'event_from');

        $timezone = new DateTimeZone(Mage::getStoreConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE));

        // change de_DE to de-DE
        $feedlocale = str_replace('_', '-', Mage::getStoreConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_LOCALE));

        $feed = new AtomFeed_Api_V1_Feed();

        // need url for namespace
        $base_url = Mage::getStoreConfig(Mage_Core_Model_Store::XML_PATH_UNSECURE_BASE_URL);
        $feed->addNamespace('e', $base_url);

        $feedtitle = Mage::getStoreConfig('eventbundle/eventfeed/title');
        $feed->setTitle($feedtitle);

        $feed->setUpdated(new DateTime("now", $timezone));
        $feed->addLink(Mage::helper('core/url')->getCurrentUrl(), "self", $feed::MIME_TYPE);

        $feed->addAttribute('xml:lang', $feedlocale);

        /**
         * @var Egovs_ProductFile_Helper_Data $helper
         * @var Mage_Catalog_Helper_Data $catalog_helper
         */
        $helper = Mage::helper('productfile');
        $catalog_helper = Mage::helper('catalog');
        $filter = $catalog_helper->getPageTemplateProcessor();

        foreach ($collection->getItems() as $item) {
            /**
             * @var Mage_Catalog_Model_Product $item
             */
            // get timezone from store config
            $timezone = new DateTimeZone($item->getStore()->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE));
            // change de_DE to de-DE
            $locale = str_replace('_', '-', $item->getStore()->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_LOCALE));

            $entry = new AtomFeed_Api_V1_Entry();

            $entry->setTitle($item->getName());
            $entry->setId($item->getProductUrl());

            // short description formated as html
            $text = new AtomFeed_APi_V1_Text($filter->filter($item->getShortDescription()), "html");
            if ($locale !== $feedlocale) {
                $text->addAttribute('xml:lang', $locale);
            }
            $entry->setSummary($text);

            // long description formated as html
            $content = new AtomFeed_Api_V1_Content($filter->filter($item->getDescription()), "html");
            if ($locale !== $feedlocale) {
                $content->addAttribute('xml:lang', $locale);
            }
            $entry->setContent($content);

            // created and updated using store timezone
            $entry->setPublished(new DateTime($item->getCreatedAt(), $timezone));
            $entry->setUpdated(new DateTime($item->getUpdatedAt(), $timezone));

            // add link to product
            $entry->addLink($item->getProductUrl(), null, 'text/html', $locale, $item->getName());

            // proprietary attributes
            $event_from = $item->getData('event_from');
            if (isset($event_from)) {
                $date = new DateTime($event_from, $timezone);
                $entry->addChild('e:period_from', $date->format(DateTime::ATOM));
            }

            $date_disable = $item->getData('date_disable');
            if (isset($date_disable)) {
                $date = new DateTime($date_disable, $timezone);
                $entry->addChild('e:period_to', $date->format(DateTime::ATOM));
            }

            // egovs productfile check for existence
            $file = $item->getProductfile();
            if (isset($file) && $helper->fileExists($file)) {
                $url = $helper->getFileUrl($file);
                $entry->addChild('e:pdffile', $url);
            }

            $feed->addEntry($entry);
        }

        $this->getResponse()->setHeader('Content-Type', $feed::MIME_TYPE . "; charset=utf-8", true);
        //$this->getResponse()->setHeader('Content-Disposition', 'attachment; filename="list.atom"');

        $this->getResponse()->setBody($feed->toXML());
        return $this->getResponse();
    }

    public function listAction() {
        $this->_forward('index');
    }
}



